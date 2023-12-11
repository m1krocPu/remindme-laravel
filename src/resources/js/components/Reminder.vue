<template>
  <div class="header">
    <div class="title">Reminders List</div>
  </div>
  <div class="data-grid">
    <DxDataGrid
      :ref="dataGridReminder"
      :data-source="reminders"
      :show-borders="true"
      key-expr="id"
    >
      <DxPaging :enabled="false"/>
      <DxEditing
        :allow-updating="true"
        :allow-adding="true"
        :allow-deleting="true"
        mode="popup"
      >
        <DxPopup
          :show-title="true"
          :width="700"
          :height="380"
          title="Reminder"
        />
        <DxForm>
          <DxItem
            :col-count="1"
            :col-span="2"
            item-type="group"
          >
            <DxItem data-field="title" caption="Title">
              <DxRequiredRule/>
            </DxItem>
            <DxItem data-field="description" caption="Description">
              <DxRequiredRule/>
            </DxItem>
            <DxItem data-field="remind_at" caption="Reminder At" data-type="datetime" >
              <DxRequiredRule/>
            </DxItem>
            <DxItem data-field="event_at"  caption="Event At" data-type="datetime">
              <DxRequiredRule/>
            </DxItem>
          </DxItem>

        </DxForm>
      </DxEditing>

      <DxToolbar>
        <DxItem
          location="before"
          template="limitSelection"
        />
        <DxItem
          location="after"
          template="refreshTemplate"
        />
        <DxItem name="addRowButton" show-text="inMenu" />
      </DxToolbar>
      <template #limitSelection>
        <DxSelectBox
          width="100"
          :items="limits"
          :input-attr="{ 'aria-label': 'Group' }"
          display-expr="value"
          value-expr="value"
          :value="10"
          label="limit"
          labelMode="static"
          placeholder="10"
          @value-changed="reload"
        />
      </template>
      <template #refreshTemplate>
        <DxButton
          icon="refresh"
          @click="reload"
        />
      </template>

      <DxColumn 
        data-field="title" 
        caption="Title"
      />
      <DxColumn 
        data-field="description" 
        caption="Description"
      />
      <DxColumn
        data-field="remind_at"
        caption="Reminder At"
        data-type="datetime"
        sort-order="asc"
      />
      <DxColumn
        data-field="event_at"
        caption="Event At"
        data-type="datetime"
      />
    </DxDataGrid>
  </div>
</template>
<script>
import {
  DxDataGrid,
  DxColumn,
  DxPaging,
  DxEditing,
  DxPopup,
  DxForm,
  DxRequiredRule,
  DxToolbar,
} from 'devextreme-vue/data-grid';
import { DxItem } from 'devextreme-vue/form';
import { DxSelectBox } from 'devextreme-vue/select-box';
import { DxButton } from 'devextreme-vue/button';
import { remindersDataSource, limit } from '../datasource/reminder.js';

const dataGridReminder = "grid-reminder"

export default {
    components: {
      DxDataGrid,
      DxColumn,
      DxPaging,
      DxEditing,
      DxPopup,
      DxForm,
      DxRequiredRule,
      DxToolbar,
      DxSelectBox,
      DxButton,
      DxItem
    },
    data() {
        return {
          dataGridReminder,
          reminders : remindersDataSource(),
          limits : limit(),
        };
    },
    computed: {
        dataGrid: function() {
          return this.$refs[dataGridReminder].instance;
        }
    },
    methods: {
      reload(e) {
        this.reminders = remindersDataSource(e.value)
        this.dataGrid.refresh();
      }
    }
};
</script>
