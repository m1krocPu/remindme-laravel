<template>
  <dx-scroll-view height="100%" width="100%" class="with-footer single-card">
     <div class="dx-card content">
      <div class="header">
        <div class="title">Log In</div>
        <div class="description">Remind Me App</div>
      </div>
      <form class="login-form" @submit.prevent="onSubmit">
        <dx-form :form-data="formData" :disabled="loading">
          <dx-item
            data-field="email"
            editor-type="dxTextBox"
            :editor-options="{ stylingMode: 'filled', placeholder: 'Email', mode: 'email' }"
          >
            <dx-required-rule message="Email is required" />
            <dx-email-rule message="Email is invalid" />
            <dx-label :visible="false" />
          </dx-item>
          <dx-item
            data-field='password'
            editor-type='dxTextBox'
            :editor-options="{ stylingMode: 'filled', placeholder: 'Password', mode: 'password' }"
          >
            <dx-required-rule message="Password is required" />
            <dx-label :visible="false" />
          </dx-item>
          <dx-button-item>
            <dx-button-options
              width="100%"
              type="default"
              template="signInTemplate"
              :use-submit-behavior="true"
            >
            </dx-button-options>
          </dx-button-item>
          <template #signInTemplate>
            <div>
              <span class="dx-button-text">
                <dx-load-indicator v-if="loading" width="24px" height="24px" :visible="true" />
                <span v-if="!loading">Log In</span>
              </span>
            </div>
          </template>
        </dx-form>
      </form>
    </div>
  </dx-scroll-view>
</template>
<script>
import DxLoadIndicator from "devextreme-vue/load-indicator";
import DxForm, {
  DxItem,
  DxEmailRule,
  DxRequiredRule,
  DxLabel,
  DxButtonItem,
  DxButtonOptions
} from "devextreme-vue/form";
import notify from 'devextreme/ui/notify';

import api from "../api.js";

export default {
  data() {
    return {
      formData: {},
      loading: false
    };
  },
  methods: {
    onSubmit: async function() {
      const { email, password } = this.formData;
      this.loading = true;

      const result = await api.logIn(email, password);
      if (!result.isOk) {
        this.loading = false;
        notify(result.message, "error", 2000);
      } else {
        this.$router.push(this.$route.query.redirect || "/");
      }
    }
  },
  components: {
    DxLoadIndicator,
    DxForm,
    DxEmailRule,
    DxRequiredRule,
    DxItem,
    DxLabel,
    DxButtonItem,
    DxButtonOptions
  }
};
</script>