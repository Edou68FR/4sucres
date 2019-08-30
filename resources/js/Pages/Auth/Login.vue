<template>
  <layout>
    <div class="card mx-auto w-full md:w-1/2 lg:w-1/3 xl:w-1/4 p-4">
      <div class="mb-3">
          <div class="text-xs mb-1">
              Adresse e-mail <span class="text-red-500">*</span>
          </div>
          <input type="email" class="form-control w-full" v-model="form.email" :disabled="loading || need_otp" />
          <div class="text-red-500 mt-1 text-xs font-bold" v-if="errors && errors.email !== undefined">
              {{ errors.email[0] }}
          </div>
      </div>
      <div class="mb-3">
          <div class="text-xs mb-1">
              Mot de passe <span class="text-red-500">*</span>
          </div>
          <input type="password" class="form-control w-full" v-model="form.password" :disabled="loading || need_otp" />
          <div class="text-red-500 mt-1 text-xs font-bold" v-if="errors && errors.password !== undefined">
              {{ errors.password[0] }}
          </div>
      </div>
      <div class="mb-3" v-if="need_otp">
          <div class="text-xs mb-1">
              OTP <span class="text-red-500">*</span>
          </div>
          <input type="text" class="form-control w-full" v-model="form.one_time_password" :disabled="loading" />
          <div class="text-red-500 mt-1 text-xs font-bold" v-if="errors && errors.one_time_password !== undefined">
              {{ errors.one_time_password[0] }}
          </div>
      </div>
      <div class="text-right mt-6">
          <button type="submit" class="btn btn-primary" v-on:click="submit()"><i class="fa fa-sign-in-alt mr-1"></i> Connexion</button>
      </div>
    </div>
  </layout>
</template>

<script>
import Layout from "@/Shared/Layout";

export default {
  components: { Layout },
  props: ['recapcha'],
  data() {
    return {
      errors: [],
      form: {
        email: '',
        password: '',
        one_time_password: '',
      },
      loading: false,
      need_otp: false,
    };
  },
  mounted() {

  },
  methods: {
    submit() {
      if (this.loading) return;

      this.loading = true;
      this.axios
        .post(route('login'), this.form)
        .then(response => {
          this.$inertia.visit(response.data.intended_url);
        })
        .catch(error => {
          this.errors = error.response.data.errors;
          if (this.errors.one_time_password) this.need_otp = true;
        })
        .finally(response => {
          this.loading = false;
        });
    }
  }
};
</script>