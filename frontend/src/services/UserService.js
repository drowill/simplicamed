import Api from './api'; 

const UserService = {
  getUser: async () => {
    const response = await Api.get('/user'); 
    console.log(response);
    return response.data; 
  },

  updateProfile: async (params) => {
    try {
        const response = await Api.patch(`/api/profissionais/${params.id}`, params);
        return response.data;
    } catch (error) {
        console.error("Erro ao atualizar o perfil:", error.response.data);
        throw error;
    }
  },
};



export default UserService;
