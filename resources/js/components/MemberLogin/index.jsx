import React, { useState } from 'react'
import PropTypes from 'prop-types'
import Grid from '@mui/material/Grid'
import TextField from '@mui/material/TextField'
import Button from '@mui/material/Button'

import { useUser } from '../../contexts/UserContext'
import { AlertError, AlertSuccess } from '../../utils/Alert'
import { loginMember, estado } from '@/services/api'

export const MemberLogin = (props) => {
    const { closeModal } = props
    const { dispatch } = useUser()
    const [email, setEmail] = useState('')
    const [pin, setPin] = useState(0)

    const handleLogin = async () => {
        const data = {
            'email': email,
            'pin': pin
        }

        const response = await loginMember(data)

        if (response.data.estado === estado.ERRO) {
            closeModal()
            AlertError({
                title: 'Erro',
                description: 'O email ou o pin estão incorretos',
                confirm: () => window.location.reload(),
            })
            return
        }

        const memberAuth = JSON.parse(response.data.data)
        console.log(memberAuth)

        dispatch({
            type: 'setUser',
            payload: memberAuth,
        })
        localStorage.setItem('userPDCAirlines2023', JSON.stringify(memberAuth))
        closeModal()
        AlertSuccess({
            title: 'Sucesso',
            description: 'Membro autenticado',
            confirm: () => window.location.reload(),
        })
    }

    return (
        <Grid item container spacing={1} justify='center'>
            <Grid item xs={12} sm={12} md={12}>
                <TextField
                    label='Email'
                    variant='outlined'
                    fullWidth
                    name='email'
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                />
            </Grid>
            <Grid item xs={12} sm={12} md={12} marginTop={2}>
                <TextField
                    label='Pin'
                    variant='outlined'
                    fullWidth
                    name='pin'
                    type='password'
                    inputMode='numeric'
                    value={pin}
                    onChange={(e) => setPin(e.target.value)}
                />
            </Grid>
            <Grid item xs={12} sm={12} md={12} marginTop={4}>
                <Button
                    variant='contained'
                    color='primary'
                    type='Submit'
                    fullWidth
                    onClick={handleLogin}
                >
                    Login
                </Button>
            </Grid>
        </Grid>
    )
}

MemberLogin.propTypes = {
    closeModal: PropTypes.func.isRequired,
}

export default MemberLogin
