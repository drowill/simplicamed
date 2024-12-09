import React, { useState, useEffect } from 'react';
import { Helmet } from 'react-helmet-async';
import UserService from '../../services/UserService'; // Importando o UserService
import InputMask from "react-input-mask";

const ProfileScreen = () => {
  const [user, setUser] = useState({
    name: '',
    email: '',
    cpf: '',
    data_nascimento: '',
    endereco: '',
    telefone: '',
  });
  const [errors, setErrors] = useState({});
  const [successMessage, setSuccessMessage] = useState('');

  useEffect(() => {
    UserService.getUser()
      .then(data => {
        setUser(data); 
      })
      .catch(error => {
        console.error("Erro ao carregar os dados do usuário", error);
      });
  }, []);

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setUser((prevUser) => ({
      ...prevUser,
      [name]: value,
    }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      console.log("meu usuário:", user);
      const updatedUser = await UserService.updateProfile(user);
      setSuccessMessage('Perfil atualizado com sucesso!');
      setErrors({});
      setUser(updatedUser); // Atualiza o estado com os dados atualizados
    } catch (error) {
      if (error.response && error.response.data.errors) {
        setErrors(error.response.data.errors); // Armazenando os erros de validação
      } else {
        setErrors({ general: 'Erro ao atualizar o perfil. Tente novamente.' });
      }
    }
  };

  return (
    <div>
      <Helmet>
        <title>Perfil - SimplificaMed</title>
      </Helmet>

      <div className="pt-5 col-md-6 offset-md-3 pb-5">
        <h2>Perfil do Usuário</h2>

        {successMessage && (
          <div className="alert alert-success">
            {successMessage}
          </div>
        )}

        <form onSubmit={handleSubmit}>
          {/* Nome */}
          <div className="form-group mb-3">
            <label htmlFor="name">Nome</label>
            <input
              type="text"
              name="name"
              className="form-control"
              value={user.name}
              onChange={handleInputChange}
              required
            />
            {errors.name && (
              <div className="alert alert-danger">{errors.name[0]}</div>
            )}
          </div>

          {/* Email */}
          <div className="form-group mb-3">
            <label htmlFor="email">Email</label>
            <input
              type="email"
              name="email"
              className="form-control"
              value={user.email}
              onChange={handleInputChange}
              required
            />
            {errors.email && (
              <div className="alert alert-danger">{errors.email[0]}</div>
            )}
          </div>

          {/* CPF */}
          <div className="form-group mb-3">
            <label htmlFor="cpf">CPF</label>
            <InputMask
              type="text"
              name="cpf"
              className="form-control"
              value={user.cpf}
              mask={"999.999.999-99"}
              onChange={handleInputChange}
            />
            {errors.cpf && (
              <div className="alert alert-danger">{errors.cpf[0]}</div>
            )}
          </div>

          {/* Data de Nascimento */}
          <div className="form-group mb-3">
            <label htmlFor="data_nascimento">Data de Nascimento</label>
            <input
              type="date"
              name="data_nascimento"
              className="form-control"
              value={user.data_nascimento}
              onChange={handleInputChange}
            />
            {errors.data_nascimento && (
              <div className="alert alert-danger">{errors.data_nascimento[0]}</div>
            )}
          </div>

          {/* Endereço */}
          <div className="form-group mb-3">
            <label htmlFor="endereco">Endereço</label>
            <input
              type="text"
              name="endereco"
              className="form-control"
              value={user.endereco}
              onChange={handleInputChange}
            />
            {errors.endereco && (
              <div className="alert alert-danger">{errors.endereco[0]}</div>
            )}
          </div>

          {/* Telefone */}
          <div className="form-group mb-3">
            <label htmlFor="telefone">Telefone</label>
            <InputMask
              type="text"
              name="telefone"
              className="form-control"
              value={user.telefone}
              onChange={handleInputChange}
              mask={"(99) 99999-9999"}
            />
            {errors.telefone && (
              <div className="alert alert-danger">{errors.telefone[0]}</div>
            )}
          </div>

          {/* Botão para atualizar */}
          <div className='text-center'>
            <button type="submit" className="btn btn-primary">
              Atualizar Perfil
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};

export default ProfileScreen;
