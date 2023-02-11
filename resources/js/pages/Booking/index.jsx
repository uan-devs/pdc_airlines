/* eslint-disable no-unused-vars */
/* eslint-disable react/prop-types */
/* eslint-disable no-useless-escape */
import React, { useEffect, useState } from 'react'
import { useLocation, useNavigate, useParams } from 'react-router-dom'
import styled from 'styled-components'
import Table from '@mui/material/Table'
import TableBody from '@mui/material/TableBody'
import TableRow from '@mui/material/TableRow'
import TableCell from '@mui/material/TableCell'
import TableContainer from '@mui/material/TableContainer'
import TableHead from '@mui/material/TableHead'
import TextField from '@mui/material/TextField'
import Grid from '@mui/material/Grid'
import FormControl from '@mui/material/FormControl'
import InputLabel from '@mui/material/InputLabel'
import Select from '@mui/material/Select'
import MenuItem from '@mui/material/MenuItem'
import Switch from '@mui/material/Switch'
import { Tooltip } from '@mui/material'
import { BsPlusCircleFill } from 'react-icons/bs'
import { MdDelete } from 'react-icons/md'
import { AdapterDayjs } from '@mui/x-date-pickers/AdapterDayjs'
import { LocalizationProvider } from '@mui/x-date-pickers/LocalizationProvider'
import { DatePicker } from '@mui/x-date-pickers/DatePicker'
import PI from 'react-phone-input-2'
import 'react-phone-input-2/lib/style.css'

import { AlertError, AlertSuccess } from '../../utils/Alert'
import Logo from '../../assets/images/logo.png'
import { useUser } from '@/contexts/UserContext'
import { estado, getFlightPrice, bookFlight } from '@/services/api'

const ReactPhoneInput = PI.default ? PI.default : PI

const Wrap = styled.div`
    width: 100%;
    height: 100%;
    margin: 0 auto;
    padding: 10px;

    @media (min-width: 576px) {
        max-width: 540px;
    }

    @media (min-width: 768px) {
        max-width: 720px;
    }

    @media (min-width: 992px) {
        max-width: 960px;
    }

    @media (min-width: 1024px) and (max-width: 1200px) {
        max-width: 960px;
    }
`

export const BoxButton = styled.button`
width: 100%;
    background: #2564CF;
    display: flex;
    justify-content: center;
    align-items: center;
    border: none;
    color: white;
    padding: 10px;
    transition: all ease .5s;

    &:hover {
            background: #0544AF;
            border-radius: 10px;
        }
`

const FloatingAddButton = ({ onClick, title }) => {
    return (
        <Tooltip title={title} arrow placement='top'>
            <button className='fixed bottom-10 right-10 flex duration-500 border-none bg-transparent' onClick={onClick}>
                <BsPlusCircleFill size={45} />
            </button>
        </Tooltip>
    )
}

const Booking = () => {
    const [clients, setClients] = useState([])
    const [nome, setNome] = useState('')
    const [nomeErro, setNomeErro] = useState(true)
    const [titulo, setTitulo] = useState('')
    const [emailErro, setEmailErro] = useState(true)
    const [sobreNomeErro, setSobreNomeErro] = useState(true)
    const [email, setEmail] = useState('')
    const [sobreNome, setSobreNome] = useState('')
    const [telefone, setTelefone] = useState(0)
    const [price, setPrice] = useState('')
    const [apiPrice, setApiPrice] = useState('')
    const [data, setData] = useState('2000/10/04')
    const [disable, setDisable] = useState(true)
    const [miles, setMiles] = useState(false)
    const { user } = useUser()
    const qtd = 2
    const url = useParams()
    const navigate = useNavigate()
    const { state } = useLocation()

    useEffect(() => {
        if (!state?.fromApp) {
            navigate('/')
        }
    }, [])

    useEffect(() => {
        const handleChangeNome = () => {
            const regex = '^[A-ZÁÉÍÓÚÀÈÌÒÙÂÊÎÔÛÃÕ][A-Za-záéíóúàèìòùãõâêîôû]*$'

            if(!nome.match(regex)) setNomeErro(true)
            else if(nome.length < 2) setNomeErro(true)
            else setNomeErro(false)


        }

        handleChangeNome()
    }, [nome])

    useEffect(() => {
        const handleChangeNome = () => {
            const regex = '^[A-ZÁÉÍÓÚÀÈÌÒÙÂÊÎÔÛÃÕ][A-Za-záéíóúàèìòùãõâêîôû]*$'

            if(!sobreNome.match(regex)) setSobreNomeErro(true)
            else if(sobreNome.length < 2) setSobreNomeErro(true)
            else setSobreNomeErro(false)


        }

        handleChangeNome()
    }, [sobreNome])

    useEffect(() => {
        const handleChangeEmail = () => {
            const regex = '^[a-zA-Z0-9]+(?:\.[a-zA-Z0-9]+)*@[a-zA-Z0-9]+(?:\.[a-zA-Z0-9]+)*$'

            if (!email.match(regex)) setEmailErro(true)
            else setEmailErro(false)
        }

        handleChangeEmail()
    }, [email])

    useEffect(() => {
        const pdc = localStorage.getItem('pdcAirlinesUAN2022')

        if (!pdc) navigate('/')
    }, [])

    useEffect(() => {
        const fetchPrice = async () => {
            const data = {
                id: url.id,
            }

            const result = await getFlightPrice(data)

            if (result.estado === estado.SUCESSO) {
                setPrice(result.data.preco)
                setApiPrice(result.data.preco)
            }
        }

        fetchPrice()
    }, [])

    const addUser = () => {
        if (nomeErro || sobreNomeErro || emailErro  || data === '' || titulo === '') return

        var repeated = false

        clients.map((c) => {
            if (c.email === email || c.telefone === telefone) {
                repeated = true
                AlertError({
                    title: 'Erro',
                    description: 'O identificador deste utilizador já existe',
                })
                return
            }
        })

        if (repeated) return

        setClients((clients) => [...clients, {
            nome: nome,
            email: email,
            titulo: titulo,
            telefone: telefone,
            data: data,
            sobrenome: sobreNome,
        }])
    }

    useEffect(() => {
        if (clients.length === 0 || nomeErro || sobreNomeErro || emailErro) setDisable(true)
        else setDisable(false)
    }, [clients, nomeErro, sobreNomeErro, emailErro])

    useEffect(() => {
        if (user && user.email !== '' && clients.length === 0) {
            setClients(c => [...clients, {
                nome: user.nome,
                sobrenome: user.sobrenome,
                email: user.email,
                telefone: user.telefone,
                data: user.data,
                titulo: user.titulo,
            }])
        }
    }, [])

    useEffect(() => {
        if (miles) {
            setPrice(Math.round(price - price * 0.1))
        } else {
            setPrice(apiPrice)
        }
    }, [miles])

    const handleBooking = async () => {
        const json = {}

        clients.map((c, i) => {
            json[`nome${i + 1}`] = c.nome
            json[`sobrenome${i + 1}`] = c.sobrenome
            json[`email${i + 1}`] = c.email
            json[`titulo${i + 1}`] = c.titulo
            json[`telefone${i + 1}`] = c.telefone
            json[`data${i + 1}`] = c.data
        })
        json['id_voo_tarifa'] = url.id
        json['qtd'] = clients.length
        json['tipo'] = 'ida'

        const result = await bookFlight(json)

        if (result.estado === estado.ERRO) {
            AlertError({
                title: 'Erro',
                description: 'Dados inválidos',
                confirm: () => {
                    localStorage.removeItem('pdcAirlinesUAN2022')
                    localStorage.removeItem('searchPdcAirlinesUAN2022')
                    window.location.reload()
                },
            })
            return
        }

        AlertSuccess({
            title: 'Sucesso',
            description: 'A compra foi concluida com sucesso',
            confirm: () => {
                localStorage.removeItem('pdcAirlinesUAN2022')
                localStorage.removeItem('searchPdcAirlinesUAN2022')
                window.location.reload()
            },
        })
    }

    console.log(telefone)

    return (
        <Wrap>
            <div className='w-full min-h-screen bg-white text-black p-5'>
                <div className='w-full flex items-center mb-20'>
                    <a
                        href='/'
                        className='p-3 rounded-full cursor-pointer'
                    >
                        <img src={Logo} alt='logo' className='w-20 h-full' />
                    </a>
                    <h1 className='text-lg'>Preencha os seus dados</h1>
                </div>

                {
                    clients.length !== 0 && (
                        <TableContainer className='mb-20'>
                            <Table>
                                <TableHead>
                                    <TableRow>
                                        <TableCell>
                                            <p className='font-bold'>
                                                Nome
                                            </p>
                                        </TableCell>
                                        <TableCell>
                                            <p className='font-bold'>
                                                Sobrenome
                                            </p>
                                        </TableCell>
                                        <TableCell>
                                            <p className='font-bold'>
                                                Telefone
                                            </p>
                                        </TableCell>
                                        <TableCell>
                                            <p className='font-bold'>
                                                Nascido
                                            </p>
                                        </TableCell>
                                        <TableCell>
                                            <p className='font-bold'>
                                                E-mail
                                            </p>
                                        </TableCell>
                                        <TableCell>
                                            <p className='font-bold'>
                                                Remover
                                            </p>
                                        </TableCell>
                                    </TableRow>
                                </TableHead>
                                <TableBody>
                                    {
                                        clients.map((c, index) => (
                                            <TableRow key={index}>
                                                <TableCell>
                                                    {c.nome}
                                                </TableCell>
                                                <TableCell>{c.sobrenome}</TableCell>
                                                <TableCell>{c.telefone}</TableCell>
                                                <TableCell sx={{ minWidth: 150 }}>
                                                    {c.data}
                                                </TableCell>
                                                <TableCell>{c.email}</TableCell>
                                                <TableCell>
                                                    <Tooltip title={`Remover ${c.nome}`} arrow placement='top'>
                                                        <button
                                                            className='border-none shadow-none bg-transparent'
                                                            onClick={() => {
                                                                if (clients.length === 0) return
                                                                setClients(clients.filter(cli => cli.email !== c.email))
                                                            }}
                                                        >
                                                            <MdDelete
                                                                size={20} className='cursor-pointer hover:text-red-600 duration-300'
                                                            />
                                                        </button>
                                                    </Tooltip>
                                                </TableCell>
                                            </TableRow>
                                        ))
                                    }
                                </TableBody>
                            </Table>
                        </TableContainer>
                    )
                }

                <Grid item container spacing={3} justify='center'>
                    <Grid item xs={12} sm={12} md={12}>
                        <div className='flex flex-col'>
                            <span>{clients.length}/{qtd}</span>
                            {
                                user.email !== '' && (
                                    <div className='flex items-center'>
                                        <Switch
                                            checked={miles}
                                            onChange={(e) => setMiles(e.target.checked)}
                                            inputProps={{ 'aria-label': 'controlled' }}
                                        />
                                        <span>Usar milhas</span>
                                    </div>
                                )
                            }
                        </div>
                    </Grid>
                    <Grid item xs={12} sm={6} md={4}>
                        <FormControl fullWidth variant='outlined'>
                            <InputLabel id='demo-simple-select-outlined-label'>
                                Título
                            </InputLabel>
                            <Select
                                labelId='demo-simple-select-outlined-label'
                                id='demo-simple-select-outlined'
                                label='Título'
                                name='occupation'
                                value={titulo}
                                onChange={(e) => setTitulo(e.target.value)}
                            >
                                <MenuItem value='sr'>
                                    Srº
                                </MenuItem>
                                <MenuItem value='sra'>
                                    Srª
                                </MenuItem>
                            </Select>
                        </FormControl>
                    </Grid>
                    <Grid item xs={12} sm={6} md={4}>
                        <TextField
                            fullWidth
                            label='Nome'
                            variant='outlined'
                            name='nome'
                            value={nome}
                            error={nomeErro}
                            onChange={(e) => setNome(e.target.value)}
                        />
                    </Grid>
                    <Grid item xs={12} sm={6} md={4}>
                        <TextField
                            fullWidth
                            label='Sobrenome'
                            variant='outlined'
                            name='sobrenome'
                            value={sobreNome}
                            error={sobreNomeErro}
                            onChange={(e) => setSobreNome(e.target.value)}
                        />
                    </Grid>
                    <Grid item xs={12} sm={6} md={4}>
                        <TextField
                            fullWidth
                            label='Email'
                            variant='outlined'
                            name='email'
                            value={email}
                            error={emailErro}
                            onChange={(e) => setEmail(e.target.value)}
                        />
                    </Grid>
                    <Grid item xs={12} sm={6} md={4}>
                        <ReactPhoneInput
                            inputStyle={{
                                width: '100%',
                                height: '57px',
                            }}
                            inputProps={{
                                name: 'phone',
                                required: true,
                                autoFocus: true,
                            }}
                            placeholder='(+244) 933 470 417'
                            specialLabel={''}
                            country={'ao'}
                            value={telefone}
                            onChange={(n) => setTelefone(n)}
                        />
                    </Grid>
                    <Grid item xs={12} sm={6} md={4}>
                        <LocalizationProvider dateAdapter={AdapterDayjs}>
                            <DatePicker
                                label='Data'
                                inputFormat='YYYY/MM/DD'
                                value={data}
                                onChange={(newValue) => {
                                    if (newValue === null) setData('')
                                    else setData(`${newValue.$y}-${newValue.$M > 9 ? '' : '0'}${newValue.$M + 1}-${newValue.$D > 9 ? '' : '0'}${newValue.$D}`)
                                }}
                                maxDate='2005/01/01'
                                renderInput={(params) => <TextField {...params} fullWidth sx={{
                                    '& label.Mui-focused': {
                                        // color: 'white',
                                    },
                                    '& .MuiInput-underline:after': {
                                        borderBottomColor: 'yellow',
                                    },
                                    '& .MuiOutlinedInput-root': {
                                        '& fieldset': {
                                            borderColor: 'white',
                                            borderRadius: 0,
                                        },
                                        '&:hover fieldset': {
                                            borderColor: 'white',
                                        },
                                        '&.Mui-focused fieldset': {
                                            // borderColor: 'yellow',
                                        },
                                    },
                                }} />}
                            />
                        </LocalizationProvider>
                    </Grid>
                    <Grid item xs={12} sm={12} md={12}>
                        <BoxButton
                            disabled={disable}
                            className={`${disable ? 'cursor-not-allowed' : 'cursor-pointer'}`}
                            onClick={handleBooking}
                        >
                            Compre {`${disable ? '' : `por ${clients.length * price} kz`}`}
                        </BoxButton>
                    </Grid>
                </Grid>

                {
                    qtd > clients.length && (
                        <FloatingAddButton
                            title='Adicionar passageiro'
                            onClick={addUser}
                        />
                    )
                }
            </div>
        </Wrap>
    )
}

export default Booking
