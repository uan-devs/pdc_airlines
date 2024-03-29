export const getCurrentMonth = () => {
    let now = new Date()

    return `${now.getFullYear()}-${now.getMonth()+1}`
}

export const formatDate = (date) => {
    let year = date.getFullYear()
    let month = date.getMonth() + 1
    let day = date.getDate()
    getTime(date)

    return `${year}-${addZeroToDate(month)}-${addZeroToDate(day)}`
}

export const addZeroToDate = (n) => n < 10 ? `0${n}` : `${n}`

export const formatMonth = (currentMonth) => {
    let [year, month] = currentMonth.split('-')
    let months = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro']

    return `${months[parseInt(month) - 1]} de ${year}`
}

export const getTime = (date) => {
    let hours = date.getUTCHours()-1
    let minutes = date.getUTCMinutes()
    let seconds = date.getSeconds()

    return `${addZeroToDate(hours)}:${addZeroToDate(minutes)}:${addZeroToDate(seconds)}`
}

export const reverseDate = (date) => {
    let [day, month, year] = date.split('-')

    return `${year}-${month}-${day}`
}

export const strToDate = (strDate) => {
    let [year, month, day] = strDate.split('-')

    return new Date(parseInt(year), parseInt(month) - 1, parseInt(day))
}
