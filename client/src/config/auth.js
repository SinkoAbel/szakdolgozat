import axios from "../config/axios";
import { useNavigate } from "react-router-dom";
import { setAuthenticated, setUserID, setToken, setUserType } from '../state/reducers/authSlice';

export const login = async (
    setLoginError,
    setSuccessfulLogin,
    email,
    password,
    endpoint,
    tokenType,
    role
) => {
    setLoginError(false);

    if (!email || !password) {
        setLoginError(true);
        return;
    }
    
    try {
        const response = await axios.post(endpoint, {
            email: email,
            password: password,
            token_type: tokenType
        });
        
        setLoginError(false);
        setSuccessfulLogin(true);

        setToken(response.data.token);
        setUserID(response.data.id);
        setAuthenticated(true);
        setUserType(role);

        return true;
    } catch (err) {
        console.log(err);
        setLoginError(true);
        setSuccessfulLogin(false);
        
        return false;
    }
}