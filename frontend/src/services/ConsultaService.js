import api from "./api"; 

const ConsultaService = {
  // Função para obter consultas
  getConsultas: async (search = '') => {
    try {
      const response = await api.get(`/api/consultas?date=${search}`);
      return response.data; 
    } catch (error) {
      console.error("Erro ao obter as consultas", error);
      throw error;
    }
  },

  getConsultasAll: async () => {
    try {
      const response = await api.get("/api/consultas");
      console.log(response);
      return response.data; 
    } catch (error) {
      console.error("Erro ao obter as consultas", error);
      throw error;
    }
  },

  

  // Função para obter uma consulta específica pelo ID
  getConsultaId: async (id) => {
    try {
      const response = await api.get(`/api/consultas/${id}`);
      return response.data; 
    } catch (error) {
      console.error("Erro ao obter a consulta", error);
      throw error;
    }
  },
  // Função para obter conjunto de consultas pelo ID dos pacientes
  getConsultaById: async (id) => {
    try {
      const response = await api.get(`/api/minhas-consultas/${id}`);
      console.log("resposta:", response);
      return response.data; // Retorna os dados da consulta
    } catch (error) {
      console.error("Erro ao obter a consulta", error);
      throw error;
    }
  },

  // Função para cadastrar uma nova consulta
  postConsulta: async (consultaData) => {
    try {
      const response = await api.post('/api/consultas', consultaData);
      return response.data; // Retorna os dados da consulta criada
    } catch (error) {
      console.error("Erro ao cadastrar a consulta", error);
      throw error;
    }
  },

  // Função para editar uma consulta existente
  updateConsulta: async (id, consultaData) => {
    try {
      const response = await api.put(`/consultas/${id}`, consultaData);
      return response.data; // Retorna os dados da consulta atualizada
    } catch (error) {
      console.error("Erro ao editar a consulta", error);
      throw error;
    }
  },

  // Função para deletar uma consulta
  deleteConsulta: async (id) => {
    try {
      const response = await api.delete(`/consultas/${id}`);
      return response.data; // Retorna a confirmação de deleção
    } catch (error) {
      console.error("Erro ao deletar a consulta", error);
      throw error;
    }
  },

  acceptedConsulta: async (id) => {
    try {
      const response = await api.get(`/api/consulta/accepted/${id}`);
      return response.data; // Retorna a confirmação de deleção
    } catch (error) {
      console.error("Erro ao aceitar a consulta", error);
      throw error;
    }
  },

  rejectedConsulta: async (id) => {
    try {
      const response = await api.get(`/api/consulta/rejected/${id}`);
      return response.data; // Retorna a confirmação de deleção
    } catch (error) {
      console.error("Erro ao rejeitar a consulta", error);
      throw error;
    }
  },

  vincularProfissionalConsulta: async (id, data) => {
    try {
      console.log("data:" ,data);
      const response = await api.post(`/api/consultas/${id}/associar-profissional`, {"profissional" : data.prof} ); 
      console.log("resposta de vínculo de profissional:", response); 
      return response;
    }catch(error){
      console.error(error);
    }
  }
};

export default ConsultaService;
