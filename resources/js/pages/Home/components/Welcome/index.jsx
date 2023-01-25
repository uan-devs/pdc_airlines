/* eslint-disable react/prop-types */
import React, { useEffect, useState } from 'react'
import InputLabel from '@mui/material/InputLabel'
import MenuItem from '@mui/material/MenuItem'
import FormControl from '@mui/material/FormControl'
import Select from '@mui/material/Select'
import { TextField } from '@mui/material'
import { AdapterDayjs } from '@mui/x-date-pickers/AdapterDayjs'
import { LocalizationProvider } from '@mui/x-date-pickers/LocalizationProvider'
import { DatePicker } from '@mui/x-date-pickers/DatePicker'
import Aos from 'aos'
import 'aos/dist/aos.css'

import * as C from './style'
import arrow from '../../../../assets/images/down-arrow.svg'
import { useNavigate } from 'react-router-dom'
import Header from '@/components/Header'

import { useForm } from "@inertiajs/inertia-react"

// https://www.youtube.com/watch?v=79rgF2VK_4E

const Welcome = ({ title, description, background, cidades }) => {
    const [disableButton, setDisableButton] = useState(true)
    const navigate = useNavigate()

    const { data, setData, post, processing, errors } = useForm({
        origem: '',
        destino: '',
        tipo: '',
        data: '',
    })

    useEffect(() => {
        Aos.init({ duration: 1500 })
    }, [])

    useEffect(() => {
        if (data.tipo !== undefined && data.tipo !== '' && data.origem !== undefined && data.origem !== '' && data.destino !== undefined && data.destino !== '' && data.data !== undefined && data.data !== '') {
            setDisableButton(false)
        }
    }, [data])

    function handleSubmit(e) {
        setData("data", `${data.data.$y}-${data.data.$M + 1}-${data.data.$D}`)
        e.preventDefault()
        post('/flySearch', {
            preserveScroll: true,
            onSuccess: () => {
                console.log(data)
            }
        }, data)
    }

    return (
        <C.Wrap bgImage={background}>
            <div className='w-full min-h-screen flex flex-col justify-between items-center py-2.5 px-7 bg-[rgba(0,0,0,.4)]'>
                <Header />

                <C.ItemText data-aos='fade-up'>
                    <h1>{title}</h1>
                    <p>{description}</p>
                </C.ItemText>

                <form method='POST' onSubmit={handleSubmit} className='w-full'>
                    <C.Box>
                        <FormControl
                            sx={{
                                minWidth: 250,
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
                            }}
                        >
                            <InputLabel id='demo-simple-select-label'>Origem</InputLabel>
                            <Select
                                labelId='demo-simple-select-label'
                                id='demo-simple-select'
                                name='origem'
                                value={data.origem}
                                label='Origem'
                                onChange={(e) => setData('origem', e.target.value)}
                                sx={{
                                    transitionDuration: '500ms',
                                    ':hover': {
                                        boxShadow: 'black 10px 10px 50px 0px',
                                    },
                                }}
                            >
                                {
                                    cidades.map((c, index) => (
                                        <MenuItem value={c.id} key={index}>
                                            {c.cidade}
                                        </MenuItem>
                                    ))
                                }
                            </Select>
                        </FormControl>
                        <FormControl
                            sx={{
                                minWidth: 250,
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
                            }}
                        >
                            <InputLabel id='demo-simple-select-label'>Destino</InputLabel>
                            <Select
                                labelId='demo-simple-select-label'
                                id='demo-simple-select'
                                name='destino'
                                value={data.destino}
                                label='Destino'
                                onChange={(e) => setData('destino', e.target.value)}
                                sx={{
                                    transitionDuration: '500ms',
                                    ':hover': {
                                        boxShadow: 'black 10px 10px 50px 0px',
                                    },
                                }}
                            >
                                {
                                    cidades.reverse().map((c, index) => (
                                        <MenuItem value={c.id} key={index}>
                                            {c.cidade}
                                        </MenuItem>
                                    ))
                                }
                            </Select>
                        </FormControl>
                        <LocalizationProvider dateAdapter={AdapterDayjs}>
                            <DatePicker
                                label='Data'
                                value={data.data}
                                onChange={(e) => setData('data', e)}
                                renderInput={(params) => <TextField {...params} sx={{
                                    minWidth: 250,
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
                        <FormControl
                            sx={{
                                minWidth: 250,
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
                            }}
                        >
                            <InputLabel id='demo-simple-select-label'>Viagem</InputLabel>
                            <Select
                                labelId='demo-simple-select-label'
                                id='demo-simple-select'
                                value={data.tipo}
                                label='Viagem'
                                name='tipo'
                                onChange={(e) => setData('tipo', e.target.value)}
                                sx={{
                                    transitionDuration: '500ms',
                                    ':hover': {
                                        boxShadow: 'black 10px 10px 50px 0px',
                                    },
                                }}
                            >
                                <MenuItem value='ida'>
                                    Só Ida
                                </MenuItem>
                                <MenuItem value='volta'>
                                    Ida e Volta
                                </MenuItem>
                            </Select>
                        </FormControl>
                        <C.BoxButton
                            type="submit"
                            name="Submit"
                        >
                            Search
                        </C.BoxButton>
                    </C.Box>
                </form>

                <C.DownArrow src={arrow} />
            </div>
        </C.Wrap >
    )
}

export default Welcome
