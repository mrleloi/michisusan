import dayjs from 'dayjs'
import 'dayjs/locale/ja'

export const useDatetime = t => {
  dayjs.locale('ja')
  return dayjs(t)
}
