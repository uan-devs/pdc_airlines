/* eslint-disable react/prop-types */
import React, { useEffect, useState } from 'react'
import { GiAirplaneDeparture } from 'react-icons/gi'

import * as F from './style'
import logo from '../../assets/images/logo.png'
import Footer from '../../components/Footer'
import { estado, getFlightResults } from '@/services/api'
import Header from '@/components/Header'

const FlySearchResult = () => {
    const [voos, setVoos] = useState([])

    useEffect(() => {
        const fetchFlights = async () => {
            const localFlights = localStorage.getItem('searchPdcAirlinesUAN2022')
            const json = localFlights ? JSON.parse(localFlights) : null

            if (json) {
                const data = {
                    tipo: 'ida',
                    origem: json.origin,
                    destino: json.destiny,
                    data: json.date,
                }

                const result = await getFlightResults(data)

                if (result.estado === estado.SUCESSO) setVoos(result.data)
            }
        }

        fetchFlights()
    }, [])

    return (
        <F.FlySearchContainer>
            <Header black />
            <F.FlySearchHeader>
                <h1 className='font-normal text-[#2564CF]'>Resultados</h1>
            </F.FlySearchHeader>
            <F.FlySearchBody>
                        {
                            voos.map((f, i) => (
                                <Results
                                    key={i}
                                    flight={f}
                                />
                            ))
                        }
                    </F.FlySearchBody>
            <Footer />
        </F.FlySearchContainer>
    )
}

const Results = ({ flight }) => {
    const [showEconomicRates, setShowEconomicRates] = useState(false)

    const toggleEconomicRates = () => {
        setShowEconomicRates(!showEconomicRates)
    }

    return (
        <div>
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
}

export default FlySearchResult
