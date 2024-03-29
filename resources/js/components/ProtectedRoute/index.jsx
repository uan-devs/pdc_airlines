import React from 'react'
import { Outlet, Navigate, useParams } from 'react-router-dom'
import { useUser } from '../../contexts/UserContext'
import Sidebar from '@/components/Sidebar'

const ProtectedRoute = () => {
    const { user } = useUser()
    const { id } = useParams()
    console.log(id, user.nome.toLowerCase().replaceAll(' ', ''))

    return (id === user.nome.toLowerCase().replaceAll(' ', '')) ? (
        <div className='flex sm:flex-row flex-col w-full h-screen bg-white'>
            <Sidebar />

            <div className='p-7 flex-1 sm:h-screen h-[90vh] overflow-y-scroll text-black'>
                <Outlet />
            </div>
        </div>
    ) : <Navigate to='/' />
}

export default ProtectedRoute
