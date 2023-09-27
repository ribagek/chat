import moment from 'moment'
import 'moment/dist/locale/ru'

export default (date, format) => {
  moment.locale('ru-RU')

  if (format) {
    return moment(date).format(format)
  }

  return moment(date).calendar()
}
