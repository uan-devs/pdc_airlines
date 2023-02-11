/* eslint-disable no-useless-escape */
/* eslint-disable react/prop-types */
import { AlertError, AlertSuccess } from '@/utils/Alert'
import { changeMemberData, changeMemberPin, estado } from '@/services/api'
import { TextField } from '@mui/material'
import React, { useEffect, useState } from 'react'
import Modal from '../../components/Modal'
import { useUser } from '../../contexts/UserContext'

const ChangeData = ({ setOpen }) => {
    const { user } = useUser()
    const [nome, setNome] = useState(user.nome)
    const [email, setEmail] = useState(user.email)
    const [nomeError, setNomeError] = useState(false)
    const [emailError, setEmailError] = useState(false)
    const [disable, setDisable] = useState(false)

    useEffect(() => {
        setDisable(emailError || nomeError || nome == '' || email == '' || nome == undefined || email == undefined || nome == null || email == null)
    }, [nome, email, nomeError, emailError])

    useEffect(() => {
        const handleChangeEmail = () => {
            const regex = '^[a-zA-Z0-9]+(?:\.[a-zA-Z0-9]+)*@[a-zA-Z0-9]+(?:\.[a-zA-Z0-9]+)*$'

            if (!email.match(regex)) setEmailError(true)
            else setEmailError(false)
        }

        handleChangeEmail()
    }, [email])

    useEffect(() => {
        const handleChangeNome = () => {
            const regex = '^[A-ZÁÉÍÓÚÀÈÌÒÙÂÊÎÔÛÃÕ][A-Za-záéíóúàèìòùãõâêîôû]*$'

            if(!nome.match(regex)) setNomeError(true)
            else if(nome.length < 2) setNomeError(true)
            else setNomeError(false)


        }

        handleChangeNome()
    }, [nome])

    const handleRequest = async () => {
        if (nome === '' || email === '') return

        if (user.nome == nome && user.email == email) {
            AlertError({
                title: 'Cancelado',
                description: 'Dados não alteraram',
            })
        }

        const data = {
            'pin': user.pin,
            'email': email,
            'nome': nome,
            'id': user.id,
        }

        const response = await changeMemberData(data)

        if (response === null || response.data.estado == estado.ERRO) {
            AlertError({
                title: 'Erro',
                description: response ? response.data.desc : 'Ocorreu algum erro inesperado',
            })
            setOpen(false)
            return
        }

        setOpen(false)
        AlertSuccess({
            title: 'Sucesso',
            description: response ? response.data.desc : 'Membro autenticado',
            confirm: () => window.location.reload(),
        })
    }

    return (
        <div className='flex flex-col gap-6'>
            <TextField
                name='fullName'
                label='Nome'
                className='my-2'
                value={nome}
                error={nomeError}
                onChange={(e) => setNome(e.target.value)}
            />

            <TextField
                name='email'
                label='E-mail'
                className='my-2'
                value={email}
                error={emailError}
                onChange={(e) => setEmail(e.target.value)}
            />

            <div className='w-full'>
                <button
                    className={`
                        p-2 w-full bg-[#2564CF] hover:bg-[#2564CF] duration-500 text-white rounded-md border-none
                        ${disable ? 'cursor-not-allowed' : 'cursor-pointer'}
                    `}
                    type='submit'
                    disabled={disable}
                    onClick={() => handleRequest()}
                >
                    Alterar
                </button>
            </div>
        </div>
    )
}

const ChangePassword = ({ setOpen }) => {
    // const { user, dispatch } = useUser()
    const [oldPassword, setOldPassword] = useState('')
    const [newPassword, setNewPassword] = useState('')
    const { user, dispatch } = useUser()
    const [oldError, setOldError] = useState(false)
    const [newError, setNewError] = useState(false)
    const [disable, setDisable] = useState(false)

    useEffect(() => {
        setDisable(oldError || newError || oldPassword == '' || newPassword == '' || oldPassword == undefined || newPassword == undefined || oldPassword == null || newPassword == null)
    }, [oldPassword, newPassword, oldError, newError])

    useEffect(() => {
        const handleChangeOld = () => {
            const regex = '^[0-9]{4,6}$'

            if (!oldPassword.match(regex)) setOldError(true)
            else setOldError(false)
        }

        handleChangeOld()
    }, [oldPassword])

    useEffect(() => {
        const handleChangeNew = () => {
            const regex = '^[0-9]{4,6}$'

            if (!newPassword.match(regex)) setNewError(true)
            else setNewError(false)
        }

        handleChangeNew()
    }, [newPassword])

    const handleRequest = async () => {
        if (oldPassword === '' || newPassword === '') return

        if (user.pin != oldPassword) {
            AlertError({
                title: 'Erro',
                description: 'Pin antigo está incorreto',
            })
        }

        const data = {
            'pin': oldPassword,
            'email': user.email,
            'novoPin': newPassword,
            'id': user.id,
        }

        const response = await changeMemberPin(data)

        if (response === null || response.data.estado == estado.ERRO) {
            AlertError({
                title: 'Erro',
                description: response ? response.data.desc : 'Ocorreu algum erro inesperado',
            })
            setOpen(false)
            return
        }

        var memberAuth = { ...user, pin: newPassword }

        dispatch({
            type: 'setUser',
            payload: memberAuth,
        })
        localStorage.setItem('userPDCAirlines2023', JSON.stringify(memberAuth))
        setOpen(false)
        AlertSuccess({
            title: 'Sucesso',
            description: response ? response.data.desc : 'Membro autenticado',
            confirm: () => window.location.reload(),
        })
    }

    return (
        <div className='flex flex-col gap-6'>
            <div className='flex justify-between'>
                <TextField
                    name='oldPassword'
                    label='Pin antigo'
                    type='password'
                    className='my-2'
                    value={oldPassword}
                    error={oldError}
                    onChange={(e) => setOldPassword(e.target.value)}
                />

                <TextField
                    name='newPassword'
                    label='Novo pin'
                    type='password'
                    className='my-2'
                    value={newPassword}
                    error={newError}
                    onChange={(e) => setNewPassword(e.target.value)}
                />
            </div>

            <div className='w-full'>
                <button
                    className={`
                        p-2 w-full bg-[#2564CF] hover:bg-[#2564CF] duration-500 text-white rounded-md border-none
                        ${disable ? 'cursor-not-allowed' : 'cursor-pointer'}
                    `}
                    disabled={disable}
                    type='submit'
                    onClick={() => handleRequest()}
                >
                    Alterar
                </button>
            </div>
        </div>
    )
}

const MemberDashboard = () => {
    const { user } = useUser()
    const [openChange, setOpenChange] = useState(false)
    const [openPassword, setOpenPassword] = useState(false)

    return (
        <div className='text-black w-full h-full overflow-visible py-10'>
            <div className='bg-white min-h-[96px] w-full hover:shadow-xl hover:rounded-3xl duration-300 rounded-lg border-b-2 border-[#132742] border-solid flex flex-col p-5'>
                <div className='flex items-center gap-5'>
                    <h1 className='font-bold text-lg'>{user.nome}</h1>
                    <h1 className='font-bold text-lg sm:flex hidden -ml-3'>{user.sobrenome}</h1>
                    <span className='bg-green-300 px-3 rounded-lg text-xs'>Membro PDC</span>
                </div>
                <span className='text-sm text-[#2564CF] font-bold'>{user.email}</span>
            </div>

            <div className='mt-20 flex justify-center gap-20'>
                <button
                    className='hover:scale-105 duration-500 px-3 py-2 bg-[#2564CF] text-white rounded-md border-none'
                    onClick={() => setOpenChange(true)}
                >
                    Editar dados
                </button>
                <button
                    className='hover:scale-105 duration-500 px-3 py-2 bg-black text-white rounded-md border-none'
                    onClick={() => setOpenPassword(true)}
                >
                    Alterar Pin
                </button>
            </div>

            <Modal
                open={openChange}
                title='Alteração dos dados'
                handleClose={() => setOpenChange(false)}
            >
                <ChangeData setOpen={setOpenChange} />
            </Modal>

            <Modal
                open={openPassword}
                handleClose={() => setOpenPassword(false)}
                title='Alteração da senha'
            >
                <ChangePassword setOpen={setOpenPassword} />
            </Modal>
        </div>
    )
}

export default MemberDashboard
