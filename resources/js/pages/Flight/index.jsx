import React, { useState } from 'react'
import { AiFillCloseCircle } from 'react-icons/ai'
import { GiAirplaneDeparture } from 'react-icons/gi'
import { MdCheckCircle } from 'react-icons/md'

import * as F from '../FlySearchResult/style'
import logo from '../../assets/images/logo.png'
import { flightInfo } from '../../assets/dummy'
import Footer from '@/components/Footer'

const FlySearchResult = () => {
    const [showDrawer, setShowDrawer] = useState(false)
    const [showModal, setShowModal] = useState(false)
    const [details, setDetails] = useState({})
    let hasResults = true

    const closeModal = () => {
        setShowModal(false)
    }

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
                <h1 className='font-normal text-[#2564CF]'>Voo #31920</h1>
            </F.FlySearchHeader>
            <F.FlySearchBody>

                <div>
                    <F.FlySearchContent className='shadow-lg my-5'>
                        <F.FlySearchContentLogo>
                            <img src={logo} alt='logo' className='md:w-full w-auto h-full' />
                        </F.FlySearchContentLogo>
                        <F.FlySearchContentBody>
                            <div className='md:w-auto w-full justify-between flex items-center gap-5'>
                                <div className='flex flex-col'>
                                    <p className='md:text-base text-sm'>{flightInfo[0].origin.time}</p>
                                    <p className='md:text-sm text-xs text-[#666666]'>{flightInfo[0].origin.shortName}</p>
                                </div>
                                <GiAirplaneDeparture size={30} />
                                <div className='flex flex-col'>
                                    <p className='md:text-base text-sm'>{flightInfo[0].destiny.time}</p>
                                    <p className='md:text-sm text-xs text-[#666666]'>{flightInfo[0].destiny.shortName}</p>
                                </div>
                                <button
                                    className='md:mx-4 mx-2 text-[#2564CF] text-[14px] font-semibold border-none bg-transparent'
                                >
                                    Detalhes
                                </button>
                                <div className=''>
                                    <p className='md:text-base text-sm'>{flightInfo[0].duration}</p>
                                    {flightInfo[0].scale && <p className='md:text-sm text-xs text-[#666666]'>Direto</p>}
                                </div>
                            </div>
                            <div className='flex md:gap-3 sm:gap-20 gap-10 self-center'>
                                {
                                    flightInfo[0].hasEconomic && (
                                        <div
                                            className={`
                                                flex lg:flex-row flex-col items-center justify-center
                                                gap-5 bg-white shadow-lg hover:shadow-2xl hover:rounded-lg
                                                duration-300 min-h-[50px] cursor-pointer px-4 lg:py-5 py-2
                                            `}
                                        >
                                            <p className='font-bold text-xs'>Económica</p>
                                            <span className='text-xs font-bold text-[#666666]'>
                                                {flightInfo[0].economic.price}
                                            </span>
                                        </div>
                                    )
                                }
                                {
                                    flightInfo[0].hasExecutive && (
                                        <div
                                            className={`
                                                flex lg:flex-row flex-col items-center justify-center
                                                gap-5 bg-white shadow-lg hover:shadow-2xl hover:rounded-lg
                                                duration-300 min-h-[50px] cursor-pointer px-4 lg:py-5 py-2
                                            `}
                                        >
                                            <p className='font-bold text-xs'>Executiva</p>
                                            <span className='text-xs font-bold text-[#666666]'>
                                                {flightInfo[0].executive.price}
                                            </span>
                                        </div>
                                    )
                                }
                            </div>
                        </F.FlySearchContentBody>
                    </F.FlySearchContent>
                    <F.FlyRatesContent>
                        <F.FlyRatesCard className='shadow-xl'>
                            <F.FlyRatesCardHeader>
                                <h2 className='text-lg'>{flightInfo[0].economic.rates[0].title}</h2>
                                <span className='font-bold text-xs text-[#2564CF]'>
                                    Condições tarifárias
                                </span>
                            </F.FlyRatesCardHeader>
                            <F.FlyRatesCardBody>
                                {
                                    flightInfo[0].economic.rates[0].bonus.map((b, i) => (
                                        <div className='flex justify-between' key={i}>
                                            <div className='flex items-center'>
                                                {b.icon}
                                                <span className='text-sm'>
                                                    {b.name}
                                                </span>
                                            </div>
                                            {
                                                b.present ? (
                                                    <MdCheckCircle color='#25a30c' />
                                                ) : (
                                                    <AiFillCloseCircle color='#a30c0c' />
                                                )
                                            }
                                        </div>
                                    ))
                                }
                            </F.FlyRatesCardBody>
                            <F.FlyRatesCardBottom>
                                <span className='text-sm font-bold'>
                                    {flightInfo[0].economic.rawPrice + flightInfo[0].economic.rawPrice * flightInfo[0].economic.rates[0].percentage} kz
                                </span>
                                <button
                                    className='text-white bg-[#2564CF] p-2 border-none rounded-md'
                                    onClick={() => {
                                        console.log(flightInfo[0].economic.rates[0])
                                    }}
                                >
                                    Selecionar
                                </button>
                            </F.FlyRatesCardBottom>
                        </F.FlyRatesCard>
                    </F.FlyRatesContent>
                    <F.FlyRatesContent>
                        <F.FlyRatesCard className='shadow-xl'>
                            <F.FlyRatesCardHeader>
                                <h2 className='text-lg'>{flightInfo[0].executive.rates[0].title}</h2>
                                <span className='font-bold text-xs text-[#2564CF]'>
                                    Condições tarifárias
                                </span>
                            </F.FlyRatesCardHeader>
                            <F.FlyRatesCardBody>
                                {
                                    flightInfo[0].executive.rates[0].bonus.map((b, i) => (
                                        <div className='flex justify-between' key={i}>
                                            <div className='flex items-center'>
                                                {b.icon}
                                                <span className='text-sm'>
                                                    {b.name}
                                                </span>
                                            </div>
                                            {
                                                b.present ? (
                                                    <MdCheckCircle color='#25a30c' />
                                                ) : (
                                                    <AiFillCloseCircle color='#a30c0c' />
                                                )
                                            }
                                        </div>
                                    ))
                                }
                            </F.FlyRatesCardBody>
                            <F.FlyRatesCardBottom>
                                <span className='text-sm font-bold'>
                                    {flightInfo[0].executive.rawPrice + flightInfo[0].executive.rawPrice * flightInfo[0].executive.rates[0].percentage} kz
                                </span>
                                <button
                                    className='text-white bg-[#2564CF] p-2 border-none rounded-md'
                                    onClick={() => {
                                        console.log(flightInfo[0].executive.rates[0])
                                    }}
                                >
                                    Selecionar
                                </button>
                            </F.FlyRatesCardBottom>
                        </F.FlyRatesCard>
                    </F.FlyRatesContent>
                </div>
            </F.FlySearchBody>
            <Footer />
        </F.FlySearchContainer>
    )
}

export default FlySearchResult
