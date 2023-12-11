import CustomStore from 'devextreme/data/custom_store';
import api from "../api.js";

const remindersDataSource = function(limit = 10) {
    const dataSource = new CustomStore({
        key: 'id',
        load: async (loadOptions) => {
            await api.refresh();
            return api.conn().get(`reminders?limit=${limit}`)
                .then((data) => (
                {
                    data: data.data.data.reminders
                }
                ))
                .catch(() => { throw new Error('Data Loading Error'); });
        },
        insert: async (values) => {
            await api.refresh();
            return api.conn().post(`reminders`, values)
        },
        update: async (key, values) => {
            await api.refresh();
            return api.conn().put(`reminders/${key}`, values)
        },
        remove: async (key) => {
            await api.refresh();
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