import React, { useEffect, useState } from 'react'
import Tooltip from '@mui/material/Tooltip'
import PropTypes from 'prop-types'
import { AiOutlineLogin } from 'react-icons/ai'
import { useNavigate } from 'react-router-dom'

import Logo from '../../assets/images/logo.png'

const NavbarItem = (props) => {
    const { title, url, classProp, button } = props
    const navigate = useNavigate()

    return (
        <li className={`mx-4 ${classProp}`}>
            {
                button ? (
                    <button
                        className='cursor-pointer duration-500 font-bold text-white bg-transparent border-none'
                        onClick={() => navigate(url)}
                    >
                        {title}
                    </button>
                ) : (
                    <a
                        href={url}
                        className='cursor-pointer duration-500 font-bold text-white'
                    >
                        {title}
                    </a>
                )
            }
        </li>
    )
}

NavbarItem.propTypes = {
    title: PropTypes.string.isRequired,
    url: PropTypes.string.isRequired,
    classProp: PropTypes.string,
    button: PropTypes.bool.isRequired,
}

const Header = () => {
    const [color, setColor] = useState(true)
    const [showModal, setShowModal] = useState(false)
    const headerElements = [
        { title: 'Descubra', url: '/#destiny', button: false },
        { title: 'Subscreva', url: '/#news', button: false },
        { title: 'Membro PDC', url: '/membro/login', button: false },
        { title: 'Check-in', url: '/', button: false },
    ]

    const closeModal = () => {
        setShowModal(false)
    }

    /*const modalSteps = [
        {
            title: 'Faça parte da família',
            width: 'md',
            children: <MemberForm closeModal={closeModal} />,
        },
        {
            title: 'Login',
            width: 'sm',
            children: <MemberLogin closeModal={closeModal} />,
        },
    ]*/

    useEffect(() => {
        const scrollListener = () => {
            setColor(window.scrollY < 165)
        }

        window.addEventListener('scroll', scrollListener)

        return () => {
            window.removeEventListener('scroll', scrollListener)
        }
    }, [])

    return (
        <header className={`h-20 w-full flex items-center md:justify-start justify-between text-white py-4 md:px-20 px-5 gap-x-5 z-10 duration-500 ${color ? 'bg-transparent' : 'bg-[rgba(0,0,0,.7)] backdrop-blur-md'}`}>
            <div className='w-full'>
                <div className='w-full flex'>
                    <div
                        className='p-3 rounded-full cursor-pointer'
                    >
                        <img src={Logo} alt='logo' className='w-20 h-full' />
                    </div>
                    <ul
                        className='
                            sm:flex hidden list-none flex-row
                            justify-space-between items-center
                            flex-initial w-full
                        '
                    >
                        {
                            headerElements.map((item, index) => (
                                <NavbarItem title={item.title} url={item.url} key={index} button={item.button} />
                            ))
                        }
                        <li className={`
                            ml-auto rounded-full p-2 flex gap-3 items-center justify-center
                            duration-500
                        `}>
                            <a href='/login'>
                                <AiOutlineLogin size={20} className='text-white duration-500' />
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
    )
}

export default Header
