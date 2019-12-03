<template>
  <layout>
    <div class="container md:w-1/2 lg:w-1/3 xl:w-1/4 mx-auto">
      <div class="cards">
        <div class="card p-6">
          <div class="page-title">
            <span>Connexion</span>
          </div>
        </div>
        <div class="card p-6">
          <div v-if="!need_otp">
            <div class="form-group">
                <label for="email">Adresse e-mail <span class="text-red-500">*</span></label>
                <input type="email" class="form-control" v-model="form.email" :disabled="loading" name="email"/>
                <div class="form-error" v-if="errors && errors.email !== undefined">
                    {{ errors.email[0] }}
                </div>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe <span class="text-red-500">*</span></label>
                <input type="password" class="form-control" v-model="form.password" :disabled="loading" name="password" />
                <div class="form-error" v-if="errors && errors.password !== undefined">
                    {{ errors.password[0] }}
                </div>
            </div>
          </div>
          <div class="form-group" v-if="need_otp">
              <img class="mx-auto" src="/img/settings/google_2fa.png">
              <label for="otp">OTP <span class="text-red-500">*</span></label>
              <input type="text" class="form-control w-full" v-model="form.one_time_password" :disabled="loading" name="otp" />
              <div class="form-error" v-if="errors && errors.one_time_password !== undefined">
                  {{ errors.one_time_password[0] }}
              </div>
          </div>
        </div>
        <div class="card p-6 text-right">
          <button type="submit" class="btn btn-primary" v-on:click="submit()"><i class="fa fa-sign-in-alt mr-1"></i> Connexion</button>
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
import Layout from "@/Layouts/Default";

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