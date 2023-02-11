/* eslint-disable no-useless-escape */
import React, { useEffect, useState } from 'react'
import PropTypes from 'prop-types'
import Grid from '@mui/material/Grid'
import TextField from '@mui/material/TextField'

import { useUser } from '../../contexts/UserContext'
import { AlertError, AlertSuccess } from '../../utils/Alert'
import { loginMember, estado } from '@/services/api'

export const MemberLogin = (props) => {
    const { closeModal } = props
    const { dispatch } = useUser()
    const [email, setEmail] = useState('')
    const [pin, setPin] = useState('0')
    const [pinError, setPinError] = useState(false)
    const [emailError, setEmailError] = useState(false)
    const [disable, setDisable] = useState(false)

    useEffect(() => {
        setDisable(pinError || emailError || email == '' || pin == '' || email == undefined || pin == undefined || email == null || pin == null)
    }, [pin, email, emailError, pinError])

    useEffect(() => {
        const handleChangeEmail = () => {
            const regex = '^[a-zA-Z0-9]+(?:\.[a-zA-Z0-9]+)*@[a-zA-Z0-9]+(?:\.[a-zA-Z0-9]+)*$'

            if (!email.match(regex)) setEmailError(true)
            else setEmailError(false)
        }

        handleChangeEmail()
    }, [email])

    useEffect(() => {
        const handleChangeOld = () => {
            const regex = '^[0-9]{4,6}$'

            if (!pin.match(regex)) setPinError(true)
            else setPinError(false)
        }

        handleChangeOld()
    }, [pin])

    const handleLogin = async () => {
        const data = {
            'email': email,
            'pin': pin,
        }

        const response = await loginMember(data)

        if (response.data.estado === estado.ERRO) {
            closeModal()
            AlertError({
                title: 'Erro',
                description: 'O email ou o pin estão incorretos',
                confirm: () => window.location.reload(),
            })
            return
        }

        const memberAuth = JSON.parse(response.data.data)
        console.log(memberAuth)

        dispatch({
            type: 'setUser',
            payload: memberAuth,
        })
        localStorage.setItem('userPDCAirlines2023', JSON.stringify(memberAuth))
        closeModal()
        AlertSuccess({
            title: 'Sucesso',
            description: 'Membro autenticado',
            confirm: () => window.location.reload(),
        })
    }

    return (
        <Grid item container spacing={1} justify='center'>
            <Grid item xs={12} sm={12} md={12}>
                <TextField
                    label='Email'
                    variant='outlined'
                    fullWidth
                    name='email'
                    value={email}
                    error={emailError}
                    onChange={(e) => setEmail(e.target.value)}
                />
            </Grid>
            <Grid item xs={12} sm={12} md={12} marginTop={2}>
                <TextField
                    label='Pin'
                    variant='outlined'
                    fullWidth
                    name='pin'
                    type='password'
                    inputMode='numeric'
                    value={pin}
                    error={pinError}
                    onChange={(e) => setPin(e.target.value)}
                />
            </Grid>
            <Grid item xs={12} sm={12} md={12} marginTop={4}>
                <button
                    className={`
                        p-2 w-full bg-[#2564CF] hover:bg-[#2564CF] duration-500 text-white rounded-md border-none
                        ${disable ? 'cursor-not-allowed' : 'cursor-pointer'}
                    `}
                    disabled={disable}
                    type='submit'
                    onClick={() => handleLogin()}
                >
                    Entrar
                </button>
            </Grid>
        </Grid>
    )
}

MemberLogin.propTypes = {
    closeModal: PropTypes.func.isRequired,
}

export default MemberLogin
