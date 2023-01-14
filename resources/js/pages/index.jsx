import { BookingProvider } from '@/contexts/BookingContext'
import React from 'react'
import { BrowserRouter, Routes, Route } from 'react-router-dom'
import Auth from './Auth'
import FlySearchResult from './FlySearchResult'
import Home from './Home'

const App = () => {
    return (
        <BrowserRouter>
            <BookingProvider>
                <Routes>
                    <Route path='/' element={<Home />} />
                    <Route path='/sign' element={<Auth />} />
                    <Route path='/flySearch' element={<FlySearchResult />} />
                </Routes>
            </BookingProvider>
        </BrowserRouter>
    )
}

export default App
