import axios from 'axios'

export const estado = {
    SUCESSO: 'ok',
    ERRO: 'erro',
}

export const API_URL = '/pdcairlines/api/'

export const AddMember = async (data) => {
    await axios({
        method: 'POST',
        data: data,
        url: `${API_URL}member/register`,
    }).then(function (response) {
        return response
    }).catch(function (response) {
        return response
    })
}

export const loginMember = async (data) => {
    var ret = null
    await axios({
        method: 'POST',
        data: data,
        url: `${API_URL}member/login`,
    }).then(function (response) {
        ret = response
    }).catch(function (response) {
        console.log(response)
    })

    return ret
}

export const changeMemberPin = async (data) => {
    var ret = null
    await axios({
        method: 'POST',
        data: data,
        url: `${API_URL}member/edit/pin`,
    }).then(function (response) {
        ret = response
    }).catch(function (response) {
        console.log(response)
    })

    return ret
}

export const changeMemberData = async (data) => {
    var ret = null
    await axios({
        method: 'POST',
        data: data,
        url: `${API_URL}member/edit/data`,
    }).then(function (response) {
        ret = response
    }).catch(function (response) {
        console.log(response)
    })

    return ret
}

export const getCountries = async () => {
    try {
        const req = await fetch(`${API_URL}countries`)
        const json = await req.json()

        return json.data
    } catch {
        return null
    }
}

export const getFlightResults = async (data) => {
    try {
        var ret = null
        await axios({
            method: 'POST',
            data: data,
            url: `${API_URL}flightSearch`,
        }).then(function (response) {
            ret = response
        }).catch(function (response) {
            console.log(response)
        })

        return ret.data
    } catch {
        return null
    }
}

export const getMembers = async () => {
    const req = await fetch(`${API_URL}member`)
    const json = await req.json()

    console.log(json)
}
