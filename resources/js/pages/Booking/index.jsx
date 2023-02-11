/* eslint-disable react/prop-types */
import React, { useState } from 'react'
import { Table, TableBody, TableCell, TableContainer, TableHead, TableRow, TextField, Grid, FormControl, InputLabel, Select, MenuItem } from '@mui/material'
import { AdapterDayjs } from '@mui/x-date-pickers/AdapterDayjs'
import { LocalizationProvider } from '@mui/x-date-pickers/LocalizationProvider'
import { DatePicker } from '@mui/x-date-pickers/DatePicker'
import PI from 'react-phone-input-2'
import 'react-phone-input-2/lib/style.css'
import { AlertSuccess } from '../../utils/Alert'
import axios from 'axios'



import { Tooltip } from '@mui/material'
import { BsPlusCircleFill } from 'react-icons/bs'
import styled from 'styled-components'
import { useEffect } from 'react'
import { usePage } from '@inertiajs/inertia-react'
import Header from '@/components/Header'

const ReactPhoneInput = PI.default ? PI.default : PI

const Wrap = styled.div`
    width: 100%;
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
            <button className='fixed bottom-10 right-20 flex duration-500 border-none' onClick={onClick}>
                <BsPlusCircleFill size={45} />
            </button>
        </Tooltip>
    )
}

const Booking = () => {
    const [clients, setClients] = useState([])
    const [nome, setNome] = useState('')
    const [titulo, setTitulo] = useState('')
    const [email, setEmail] = useState('')
    const [sobreNome, setSobreNome] = useState('')
    const [telefone, setTelefone] = useState(0)
    const [data, setData] = useState('')
    const [disable, setDisable] = useState(true)
    const params = window.location.href
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    console.log(usePage().props)
    const localType = localStorage.getItem('tipoPDCAirlines2023')
    console.log(localType)

    const addUser = () => {
        if (nome === '' || titulo === '' || email === '' || sobreNome === '' || telefone === '' || data === '') return
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
        setDisable(clients.length === 0)
    }, [clients])

    const handleBooking = () => {
        const json = {}

        clients.map((c, i) => {
            json[`nome${i+1}`] = c.nome
            json[`sobrenome${i+1}`] = c.sobrenome
            json[`email${i+1}`] = c.email
            json[`titulo${i+1}`] = c.titulo
            json[`telefone${i+1}`] = c.telefone
            json[`data${i+1}`] = c.data
        })
        json['id_voo_tarifa'] = params.split('/')[params.split('/').length-1]
        json['qtd'] = clients.length
        json['tipo'] = localType

        console.log(json)

        const formData = new FormData()

        for(let key in clients) {
            formData.append(key, clients[key])
        }

        fetch('/api/book', {
            method: 'POST', // *GET, POST, PUT, DELETE, etc.
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
                // 'Content-Type': 'application/x-www-form-urlencoded',
             },
             body: JSON.stringify(json) // body data type must match "Content-Type" header
         })
        .then(function (response) {
            //handle success
            AlertSuccess({
                title: 'Sucesso',
                description: 'A compra foi concluida com sucesso',
            })
            console.log(response);
          })
          .catch(function (response) {
            //handle error
            console.log(response);
        });
    }

    return (
        <Wrap>
            <div className='w-full min-h-screen bg-white text-black p-5'>
                <div className='w-full mb-20'>
                    <h1>Voe connosco</h1>
                </div>

                {
                    clients.length !== 0 && (
                        <TableContainer className='mb-20'>
                            <Table>
                                <TableHead>
                                    <TableRow>
                                        <TableCell>
                                            Nome
                                        </TableCell>
                                        <TableCell>Sobrenome</TableCell>
                                        <TableCell>Telefone</TableCell>
                                        <TableCell>Nascido</TableCell>
                                        <TableCell>E-mail</TableCell>
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
                                                <TableCell>{c.data}</TableCell>
                                                <TableCell>{c.email}</TableCell>
                                            </TableRow>
                                        ))
                                    }
                                </TableBody>
                            </Table>
                        </TableContainer>
                    )
                }

                <Grid item container spacing={3} justify='center'>
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
                                setData(`${newValue.$y}-${newValue.$M > 9 ? '' : '0'}${newValue.$M + 1}-${newValue.$D > 9 ? '' : '0'}${newValue.$D}`)
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
                            Compre {`${disable ? '' : `por ${clients.length * usePage().props.preco.preco} kz`}`}
                        </BoxButton>
                    </Grid>
                </Grid>

                <FloatingAddButton
                    title='Adicionar passageiro'
                    onClick={addUser}
                />
            </div>
        </Wrap>
    )
}

export default Booking