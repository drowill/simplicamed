import api from "./api";

const AuthService = {
  register: async (params) => {
    console.log("parametros:", params);
    const response = await api.post("/register", params);
    console.log("resposta:", response.data);
    return response.data;
  },

  login: async (params) => {
    const response = await api.post("/login", params);
    localStorage.setItem("XSRF-TOKEN", response.data.token); // Armazenar o token de autenticação corretamente
    return response.data;
  },

  logout: async () => {
    const response = await api.post("/logout");
    localStorage.removeItem("XSRF-TOKEN"); // Remove o token de autenticação
    return response;
  },

  registerSuap: async (params) => {
    const response = await api.post("/gerar-token", params);
    console.log(response);
  },

  // Função para iniciar o login com Google
  loginWithGoogle: async () => {
    try {
      const oauthUrl = await api.get('/auth/google');
      console.log(oauthUrl.data.url);
      window.location.href = oauthUrl.data.url;
    } catch (error) {
      console.error("Erro ao iniciar o login com o Google:", error);
    }
  },

  // Função para lidar com o callback do Google
  handleGoogleCallback: async () => {
    try {
      const response = await api.get('/auth/google-callback');
      if (response.status === 200 && response.data.message === 'Logado com google') {
        localStorage.setItem("authToken", response.data.token);
        window.location.href = '/home'; // Redireciona para a página /home após o login
      } else {
        console.error("Falha ao obter o token de autenticação ou mensagem de sucesso");
      }
    } catch (error) {
      console.error("Erro ao lidar com o callback do Google:", error);
    }
  }
};

export default AuthService;
