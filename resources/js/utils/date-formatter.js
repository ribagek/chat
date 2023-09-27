import moment from 'moment'
import 'moment/dist/locale/ru'

export default (date, format) => {
  moment.locale('ru-RU')

  if (format) {
    return moment(date).calendar(format)
  }

  return moment(date).calendar()
}
