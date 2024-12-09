import React, { useState, useEffect } from "react";
import { Navigate } from "react-router-dom";
import UserService from "../../../services/UserService";

function PrivateRouter({ children }) {
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const handleGetUser = async () => {
      try {
        const response = await UserService.getUser();
        console.log("user logado:", response);
        setUser(response);
      } catch (error) {
        console.error("Erro ao obter usuário:", error);
      } finally {
        setLoading(false);
      }
    };

    handleGetUser();
  }, []);

  if (loading) {
    return <p>Carregando...</p>;
  }

  return user?.email ? children : <Navigate to="/" />;
}

export default PrivateRouter;
