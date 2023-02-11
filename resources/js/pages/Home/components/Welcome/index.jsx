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
import Header from '../../../../components/Header'
import { getCountries } from '@/services/api'
import { formatDate } from '@/helpers/date'

// https://www.youtube.com/watch?v=79rgF2VK_4E

const Welcome = ({ title, description, background }) => {
    const [trip, setTrip] = useState('')
    const [origin, setOrigin] = useState()
    const [destinyError, setDestinyError] = useState(false)
    const [destiny, setDestiny] = useState()
    const [origins, setOrigins] = useState([])
    const [destinies, setDestinies] = useState([])
    const [date, setDate] = useState('')
    const [disableButton, setDisableButton] = useState(true)
    const navigate = useNavigate()

    useEffect(() => {
        Aos.init({ duration: 1500 })
    }, [])

    useEffect(() => {
        const handleSelect = () => {
            if(origin === undefined || origin === null || destiny === undefined || destiny === null) return

            if(origin.id === destiny.id) setDestinyError(true)
            else setDestinyError(false)
        }

        handleSelect()
    }, [origin, destiny])

    useEffect(() => {
        const fetchCountries = async () => {
            const countries = await getCountries()

            if(countries) {
                setDestinies(countries)
                setOrigins(countries)
            }
        }

        fetchCountries()
    }, [])

    useEffect(() => {
        setDisableButton(destinyError || trip === undefined || trip === '' || origin === undefined || origin === null || destiny === undefined || destiny === null || date === undefined || date === '')
    }, [trip, origin, destiny, date])

    const handleSearch = () => {
        if (disableButton) return

        localStorage.setItem('searchPdcAirlinesUAN2022', JSON.stringify({
            origin: origin,
            destiny: destiny,
            date: date,
            trip: trip,
        }))
        navigate('/flightResults')
    }

    return (
        <C.Wrap bgImage={background}>
            <div className='w-full min-h-screen flex flex-col justify-between items-center py-2.5 px-7 bg-[rgba(0,0,0,.4)]'>
                <Header />

                <C.ItemText data-aos='fade-up'>
                    <h1>{title}</h1>
                    <p>{description}</p>
                </C.ItemText>

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
                            value={origin}
                            label='Origem'
                            onChange={(e) => setOrigin(e.target.value)}
                            sx={{
                                transitionDuration: '500ms',
                                ':hover': {
                                    boxShadow: 'black 10px 10px 50px 0px',
                                },
                            }}
                        >
                            {
                                origins.map((o, index) => (
                                    <MenuItem value={o} key={index}>
                                        {o.nome}
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
                            value={destiny}
                            label='Destino'
                            onChange={(e) => setDestiny(e.target.value)}
                            error={destinyError}
                            sx={{
                                transitionDuration: '500ms',
                                ':hover': {
                                    boxShadow: 'black 10px 10px 50px 0px',
                                },
                            }}
                        >
                            {
                                destinies.map((d, index) => (
                                    <MenuItem value={d} key={index}>
                                        {d.nome}
                                    </MenuItem>
                                ))
                            }
                        </Select>
                    </FormControl>
                    <LocalizationProvider dateAdapter={AdapterDayjs}>
                        <DatePicker
                            label='Data'
                            value={date}
                            inputFormat='YYYY/MM/DD'
                            minDate={formatDate(new Date())}
                            onChange={(newValue) => {
                                if(newValue === null) setDate('')
                                else setDate(`${newValue.$y}-${newValue.$M > 9 ? '' : '0'}${newValue.$M + 1}-${newValue.$D > 9 ? '' : '0'}${newValue.$D}`)
                            }}
                            renderInput={(params) => <TextField {...params} sx={{
                                minWidth: 250,
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
                            value={trip}
                            label='Viagem'
                            onChange={(e) => setTrip(e.target.value)}
                            sx={{
                                transitionDuration: '500ms',
                                ':hover': {
                                    boxShadow: 'black 10px 10px 50px 0px',
                                },
                            }}
                        >
                            <MenuItem value='1'>
                                Só Ida
                            </MenuItem>
                            <MenuItem value='2'>
                                Ida e Volta
                            </MenuItem>
                        </Select>
                    </FormControl>
                    <C.BoxButton
                        onClick={() => handleSearch()} disabled={disableButton}
                        className={`${disableButton ? 'cursor-not-allowed' : 'cursor-pointer'}`}
                    >
                        Search
                    </C.BoxButton>
                </C.Box>

                <C.DownArrow src={arrow} />
            </div>
        </C.Wrap >
    )
}

export default Welcome
