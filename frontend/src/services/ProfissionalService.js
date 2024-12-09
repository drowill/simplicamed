import Api from "./api"; // Certifique-se de configurar adequadamente a conexão com a API

const ProfissionalService = {
  // Obter todos os profissionais
  getProfissionais: async (search = "") => {
    try {
      const response = await Api.get(`/api/profissionais?search=${search}`);
      return response.data;
    } catch (error) {
      console.error("Erro ao obter os profissionais", error);
      throw error;
    }
  },



  getProfissionaisAll: async () => {
    try{
      const response = await Api.get("/api/profissionais");
      console.log(response.data);
      return response.data;
    }catch(error){
      console.error("Erro ao obter os profissionais", error);
      throw error;
    }
  },

  // Obter um profissional pelo ID
  getProfissionalById: async (id) => {
    try {
      const response = await Api.get(`/api/profissionais/${id}`);
      return response.data;
    } catch (error) {
      console.error("Erro ao obter o profissional", error);
      throw error;
    }
  },

  // Cadastrar um novo profissional
  postProfissional: async (profissionalData) => {
    try {
      const response = await Api.post('/api/profissionais', profissionalData);
      return response.data;
    } catch (error) {
      console.error("Erro ao cadastrar o profissional", error);
      throw error;
    }
  },

  // Atualizar os dados de um profissional existente
  updateProfissional: async (id, profissionalData) => {
    try {
      const response = await Api.put(`/api/profissionais/${id}`, profissionalData);
      return response.data;
    } catch (error) {
      console.error("Erro ao atualizar o profissional", error);
      throw error;
    }
  },

  // Deletar um profissional
  deleteProfissional: async (id) => {
    try {
      const response = await Api.delete(`/api/profissionais/${id}`);
      return response.data;
    } catch (error) {
      console.error("Erro ao deletar o profissional", error);
      throw error;
    }
  },
};

export default ProfissionalService;
