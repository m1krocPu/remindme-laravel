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
      :show-row-lines="true"
    >
      <DxPaging :enabled="false"/>
      <DxEditing
        :allow-updating="true"
        :allow-adding="true"
        :allow-deleting="true"
        :use-icons="true"
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
        :width="110"
        :allow-sorting="false"
        type="buttons"
      >
        <DxButton name="edit"/>
        <DxButton name="delete"/>
        <DxButton
          hint="Detail"
          icon="search"
          @click="detail"
        />
      </DxColumn>
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
      
      <DxMasterDetail
        :enabled="false"
        template="detailTemplate"
      />
      <template #detailTemplate>
        <div class="reminder-info">
          <h3>{{ reminder.title }} 
            <div 
            class="dx-button dx-button-mode-text dx-pull-right"
            @click="closeDetail"
          >
            <div class="dx-button-content"><i class="dx-icon dx-icon-close"></i></div>
          </div>
          </h3>
          <p>{{ reminder.description }}</p>
          <hr/>
          <span>Reminder At: <i>{{ formatDateTime(reminder.remind_at) }}</i></span>
          <span>Event At: <i>{{ formatDateTime(reminder.event_at) }}</i></span>
        </div>
      </template>
    </DxDataGrid>
    <DxLoadPanel
      :position="{of: '.dx-datagrid'}"
      v-model:visible="loading"
      :show-indicator="true"
      :show-pane="true"
      :shading="true"
      :hide-on-outside-click="false"
      shading-color="rgba(0,0,0,0.4)"
    />
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
  DxMasterDetail,
  DxSelection,
  DxButton,
  DxToolbar,
} from 'devextreme-vue/data-grid';
import { DxItem } from 'devextreme-vue/form';
import { DxSelectBox } from 'devextreme-vue/select-box';
import { DxLoadPanel } from 'devextreme-vue/load-panel';
import { remindersDataSource, limit } from '../datasource/reminder.js';
import api from "../api.js";
import moment from "moment";

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
      DxMasterDetail,
      DxSelection,
      DxButton,
      DxItem,
      DxLoadPanel
    },
    data() {
      return {
          dataGridReminder : "grid-reminder",
          reminders : remindersDataSource(),
          limits : limit(),
          reminder : [],
          loading: false
        };
    },
    computed: {
        dataGrid: function() {
          return this.$refs[this.dataGridReminder].instance;
        }
    },
    methods: {
      async detail(e) {
        this.loading = true;
        let key = e.row.data.id;
        let result = await api.getReminderDetail(key);

        if (result.isOk) {
          this.loading = false;
          this.reminder = result.data;
          this.formatDateTime(this.reminder.remind_at)
          e.component.collapseAll(-1);
          e.component.expandRow(key);
        }
        
      },
      closeDetail(){
        this.dataGrid.collapseAll(-1);
      },
      formatDateTime(timestamp) {
        return moment.unix(timestamp/1000).format('DD/MM/YYYY hh:mm A')

      },
      reload(e) {
        this.reminders = remindersDataSource(e.value)
        this.dataGrid.refresh();
      }
    }
};
</script>
