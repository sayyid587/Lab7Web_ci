const Login = {
  template: `
        <div class="login-container">
            <div class="login-box">
                <h2>Form Login Admin</h2>
                <form @submit.prevent="handleLogin">
                    <div class="form-group">
                        <label>Username / Email</label>
                        <input type="text" v-model="username" placeholder="Masukkan username" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" v-model="password" placeholder="Masukkan password" required>
                    </div>
                    <button type="submit" class="btn-login">Masuk Aplikasi</button>
                </form>
                <p v-if="errorMessage" class="error-msg">{{ errorMessage }}</p>
            </div>
        </div>
    `,
  data() {
    return {
      username: "",
      password: "",
      errorMessage: "",
    };
  },
  methods: {
    handleLogin() {
      // Tembak API Login CodeIgniter (Pastikan portnya 8080 sesuai project kamu)
      axios
        .post("http://localhost:8080/api/login", {
          username: this.username,
          password: this.password,
        })
        .then((response) => {
          if (response.data.status === 200) {
            // Simpan status login ke Local Storage browser
            localStorage.setItem("isLoggedIn", "true");
            localStorage.setItem("userToken", response.data.data.token);

            // Alihkan halaman ke manajemen artikel dan refresh
            this.$router.push("/artikel").then(() => {
              window.location.reload();
            });
          }
        })
        .catch((error) => {
          // Tangkap pesan error dari response backend jika gagal login
          if (error.response && error.response.data.messages) {
            this.errorMessage = error.response.data.messages;
          } else {
            this.errorMessage = "Terjadi kesalahan jaringan atau server.";
          }
        });
    },
  },
};
