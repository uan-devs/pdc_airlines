// React
import React from 'react'
import { BrowserRouter, Routes, Route } from 'react-router-dom'

// Hooks
import { BookingProvider } from '@/contexts/BookingContext'
import { UserProvider } from '@/contexts/UserContext'

// Pages
import Auth from './Auth'
import Booking from './Booking'
import FlySearchResult from './FlySearchResult'
import MyFlight from './MyFlight'
import MemberFlights from './MemberFlights'
import Page404 from '../pages/Page404'
import MemberDashboard from './MemberDashboard'
import Home from './Home'

import ProtectedRoute from '@/components/ProtectedRoute'

const App = () => {
    return (
        <BrowserRouter>
            <UserProvider>
                <Routes>
                    <Route path='/' element={<Home />} />
                    <Route path='/sign' element={<Auth />} />
                    <Route path='/flightResults' element={<FlySearchResult />} />
                    <Route path='/bookFlight/:id' element={<Booking />} />
                    <Route path='/search' element={<MyFlight />} />
                    <Route path='/member/:id' element={<ProtectedRoute />}>
                        <Route path='/member/:id' element={<MemberDashboard />} />
                        <Route path='/member/:id/flights' element={<MemberFlights />} />
                    </Route>
                    <Route path='/*' element={<Page404 />} />
                </Routes>
            </UserProvider>
        </BrowserRouter >
    )
}

export default App
