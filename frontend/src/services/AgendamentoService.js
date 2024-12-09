import api from "./api";

const AgendamentoService = {
  // Função para obter as consultas
  getConsultas: async (date) => {
    try {
      const response = await api.get(`/consultas/${date}`);
      return response.data;
    } catch (error) {
      console.error("Erro ao obter as consultas", error);
      throw error;
    }
  },

  // Função para cadastrar uma nova consulta (POST)
  post: async (consultaData) => {
    try {
      console.log(consultaData);
      const response = await api.post('/api/consultas', consultaData);
      return response; 
    } catch (error) {
      console.error("Erro ao cadastrar a consulta", error);
      throw error;
    }
  },
};

export default AgendamentoService;
