import React, { useState } from 'react'
import Drawer from '@mui/material/Drawer'
import { AiFillCloseCircle } from 'react-icons/ai'
import { GiAirplaneDeparture } from 'react-icons/gi'
import { MdCheckCircle } from 'react-icons/md'

import * as F from './style'
import logo from '../../assets/images/logo.png'
import FlightDetails from './FlightDetails'
import Modal from '@/components/Modal'
import BookingForm from '@/components/BookingForm'
import SelectPlace from '@/components/SelectPlace'
import Footer from '@/components/Footer'
import { usePage, Link } from '@inertiajs/inertia-react'

const FlySearchResult = () => {
    const [showDrawer, setShowDrawer] = useState(false)
    const [showModal, setShowModal] = useState(false)
    const [details, setDetails] = useState({})
    const [state, setState] = useState(0)
    const { voos, tipo } = usePage().props
    console.log(voos, tipo)
    localStorage.setItem('tipoPDCAirlines2023', tipo)

    const closeModal = () => {
        setShowModal(false)
    }

    const modalSteps = [
        {
            title: 'Selecione o seu lugar',
            children: <SelectPlace closeModal={closeModal} state={state} setState={setState} />,
        },
        {
            title: 'Dados pessoais',
            children: <BookingForm closeModal={closeModal} state={state} setState={setState} />,
        },
    ]

    const toggleDrawer = (open) => (event) => {
        if (
            event.type === 'keydown' &&
            ((event).key === 'Tab' ||
                (event).key === 'Shift')
        ) {
            return
        }
        setShowDrawer(!open)
    }

    const toggleDetails = (info, open) => {
        setDetails(info)
        setShowDrawer(open)
    }

    return (
        <F.FlySearchContainer>
            <F.FlySearchHeader>
                <h1 className='font-normal text-[#2564CF]'>Resultados</h1>
            </F.FlySearchHeader>
            <F.FlySearchBody>
                {voos.map((flight, index) => {
                    const [showEconomicRates, setShowEconomicRates] = useState(false)

                    const toggleEconomicRates = () => {
                        setShowEconomicRates(!showEconomicRates)
                    }

                    return (
                        <div key={index}>
                            <F.FlySearchContent className='shadow-lg my-5'>
                                <F.FlySearchContentLogo>
                                    <img src={logo} alt='logo' className='md:w-full w-auto h-full' />
                                </F.FlySearchContentLogo>
                                <F.FlySearchContentBody>
                                    <div className='md:w-auto w-full justify-between flex items-center gap-5'>
                                        <div className='flex flex-col'>
                                            <p className='md:text-sm text-xs text-[#666666]'>{flight.cidade_origem.slice(0, 2)}</p>
                                        </div>
                                        <GiAirplaneDeparture size={30} />
                                        <div className='flex flex-col'>
                                            <p className='md:text-sm text-xs text-[#666666]'>{flight.cidade_destino.slice(0, 2)}</p>
                                        </div>
                                        <button
                                            className='md:mx-4 mx-2 text-[#2564CF] text-[14px] font-semibold border-none bg-transparent'
                                            onClick={() => toggleDetails(flight, true)}
                                        >
                                            Detalhes
                                        </button>
                                        <div className=''>
                                            <p className='md:text-base text-sm'>{flight.chegada.slice(11)}</p>
                                        </div>
                                    </div>
                                    {
                                        flight.tarifas.map((tarifa, index) => (
                                            <div className='flex md:gap-3 sm:gap-20 gap-10 self-center' key={index}>
                                                <div
                                                    className={`
                                                    flex lg:flex-row flex-col items-center justify-center
                                                    gap-5 bg-white shadow-lg hover:shadow-2xl hover:rounded-lg
                                                    duration-300 min-h-[50px] cursor-pointer px-4 lg:py-5 py-2
                                                `}
                                                    onClick={() => toggleEconomicRates()}
                                                >
                                                    <p className='font-bold text-xs'>{tarifa.classe_nome}</p>
                                                    <span className='text-xs font-bold text-[#666666]'>
                                                        {tarifa.preco}
                                                    </span>
                                                </div>
                                            </div>
                                        ))
                                    }
                                </F.FlySearchContentBody>
                            </F.FlySearchContent>

                            {
                                (showEconomicRates) &&
                                (
                                    <F.FlyRatesContent>
                                        {
                                            flight.tarifas.map((rate, i) => (
                                                <F.FlyRatesCard className='shadow-xl' key={i}>
                                                    <F.FlyRatesCardHeader>
                                                        <h2 className='text-lg'>{rate.tarifa}</h2>
                                                        <span className='font-bold text-xs text-[#2564CF]'>
                                                            Condições tarifárias
                                                        </span>
                                                    </F.FlyRatesCardHeader>
                                                    <F.FlyRatesCardBody>
                                                        <div className='flex justify-between' key={i}>
                                                            <p>Lugares</p>
                                                            <p>{rate.lugares}</p>
                                                        </div>
                                                    </F.FlyRatesCardBody>
                                                    <F.FlyRatesCardBottom>
                                                        <span className='text-sm font-bold'>
                                                            {rate.preco} kz
                                                        </span>
                                                        <a
                                                            className='text-white bg-[#2564CF] p-2 border-none rounded-md'
                                                            href={`/book/${rate.id_voo_tarifa}`}
                                                        >
                                                            Selecionar
                                                        </a>
                                                    </F.FlyRatesCardBottom>
                                                </F.FlyRatesCard>
                                            ))
                                        }
                                    </F.FlyRatesContent>
                                )
                            }
                        </div>
                    )
                })}
            </F.FlySearchBody>
            <Drawer
                anchor='right'
                open={showDrawer}
                onClose={toggleDrawer(true)}
            >
                <FlightDetails flight={details} />
            </Drawer>
            <Modal
                open={showModal}
                handleClose={() => setShowModal(false)}
                title={modalSteps[state].title}
            >
                {modalSteps[state].children}
            </Modal>
            <Footer />
        </F.FlySearchContainer>
    )
}

export default FlySearchResult
