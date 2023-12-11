import CustomStore from 'devextreme/data/custom_store';
import api from "../api.js";

const remindersDataSource = function(limit = 10) {
    const dataSource = new CustomStore({
        key: 'id',
        load: (loadOptions) => {
            return api.conn().get(`reminders?limit=${limit}`)
                .then((data) => (
                {
                    data: data.data.data.reminders
                }
                ))
                .catch(() => { throw new Error('Data Loading Error'); });
        },
        insert: (values) => {
            return api.conn().post(`reminders`, values)
        },
        update: (key, values) => {
            return api.conn().put(`reminders/${key}`, values)
        },
        remove: (key) => {
            return api.conn().delete(`reminders/${key}`)
        },
      });

      return dataSource
}

const limit = function() {
    let limits = []
    for(let i=1;i<=10;i++){
        limits.push(
            {
                value: i
            }
        )
    }
    return limits
}

export default remindersDataSource
export { remindersDataSource, limit }