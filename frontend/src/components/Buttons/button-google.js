import React from "react";
import { FaGoogle } from "react-icons/fa";

const GoogleLoginButton = ({ handleLoginGoogle }) => {
  return (
    <button onClick={handleLoginGoogle} className="btn btn-danger w-100">
      <FaGoogle className="me-2" />
      Login com o Google
    </button>
  );
};


export default GoogleLoginButton;
