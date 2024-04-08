import sessionStorage from "redux-persist/es/storage/session";
import axios from "../config/axios";
import { useSelector } from "react-redux";

export const login = async (
    setLoginError,
    setSuccessfulLogin,
    email,
    password,
    endpoint,
    tokenType,
) => {
    setLoginError(false);
    setSuccessfulLogin(false);

    if (!email || !password) {
        setLoginError(true);
        return false;
    }
    
    try {
        const response = await axios.post(endpoint, {
            email: email,
            password: password,
            token_type: tokenType
        });

        if (response.status === 200) {
            setLoginError(false);
            setSuccessfulLogin(true);

            return {
                token: `Bearer ${response.data.token}`,
                userID: response.data.id
            };
        } else {
            setLoginError(true);
            setSuccessfulLogin(false);
            return false;
        }
    } catch (err) {
        console.log(err);
        setLoginError(true);
        setSuccessfulLogin(false);
        return false;
    }
}


export const logout = async (token) => {
    await axios.post('/api/logout', {}, {
        headers: {
            Authorization: token
        }
    }).then((response) => {
        return true;
    }).catch((err) => {
        console.log(err);
        return false;
    });
}