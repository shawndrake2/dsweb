import moment from 'moment'

class TimeHelper
{
  constructor () {
    this.minute = 60
    this.hour = this.minute * 60
    this.day = this.hour * 24
  }

  getAuctionTimeAsString (listingDate) {
    const now = moment()
    listingDate = moment.unix(listingDate)
    const diff = now.subtract(listingDate.seconds())

    if (diff.seconds() === 0) {
      // Instant
      return '<span style="font-weight:bold;">a few ms ago</span>'
    } else if (diff < this.minute) {
      // Few seconds ago
      return `<span style='font-weight:bold;'>${diff} secs</span>`
    } else if (diff < this.hour) {
      // Few minutes ago
      const minutes = Math.round(diff / this.minute)
      return `<span style='font-weight:bold;'>${minutes} mins</span>`
    } else if (diff < this.day) {
      // Few hours ago
      const hours = Math.floor(diff / this.hour)
      const seconds = diff % this.hour
      const minutes = Math.round(seconds / this.minute)
      return `${hours} hrs, ${minutes} mins`
    } else {
      return listingDate.format('MMMM Do YYYY, h:mm:ss a')
    }
  }

  getPlaytimeAsString (playTime) {
    const days = Math.floor(playTime / this.day)

    const hourSeconds = playTime % this.day
    const hours = Math.floor(hourSeconds / this.hour)

    const minuteSeconds = hourSeconds % this.hour
    const minutes = Math.floor(minuteSeconds / this.minute)

    const remainingSeconds = minuteSeconds % this.minute
    const seconds = Math.ceil(remainingSeconds)

    return `${days} days, ${hours} hours, ${minutes} minutes, ${seconds} seconds`
  }
}

export default TimeHelper