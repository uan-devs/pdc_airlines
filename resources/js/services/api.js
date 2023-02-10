import axios from "axios"

export const estado = {
    SUCESSO: 'ok',
    ERRO: 'erro',
}

export const API_URL = '/pdcairlines/api/'

export const AddMember = async (data) => {
    await axios({
        method: 'POST',
        data: data,
        url: `${API_URL}member/register`
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
        url: `${API_URL}member/login`
    }).then(function (response) {
        ret = response
    }).catch(function (response) {

    })

    return ret
}

export const changeMemberPin = async (data) => {
    var ret = null
    await axios({
        method: 'POST',
        data: data,
        url: `${API_URL}member/login`
    }).then(function (response) {
        ret = response
    }).catch(function (response) {

    })

    return ret
}

export const getMembers = async () => {
    const req = await fetch(`${API_URL}member`)
    const json = await req.json()

    console.log(json)
}
