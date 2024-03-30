import sessionStorage from "redux-persist/es/storage/session";
import axios from "../config/axios";

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
    setSuccessfulLogin(false);

    if (!email || !password) {
        setLoginError(true);
        return;
    }
    
    await axios.post(endpoint, {
        email: email,
        password: password,
        token_type: tokenType
    }).then((response) => {
        if (response.status === 200) {
            setLoginError(false);
            setSuccessfulLogin(true);;

            window.sessionStorage.setItem('token', 'Bearer ' +  response.data.token);
            window.sessionStorage.setItem('user_id', response.data.id);
            window.sessionStorage.setItem('authenticated', true);
            window.sessionStorage.setItem('role', role);
        } else {
            setLoginError(true);
            setSuccessfulLogin(false);
        }
    }).catch((err) => {
        console.log(err);
        setLoginError(true);
        setSuccessfulLogin(false);
    });
}


export const logout = async () => {
    const token = window.sessionStorage.getItem('token');
    console.log(token);

    await axios.post('/api/logout', {}, {
        headers: {
            Authorization: token
        }
    }).then((response) => {
        sessionStorage.removeItem('token');
        sessionStorage.removeItem('user_id');
        sessionStorage.removeItem('authenticated');
        sessionStorage.removeItem('role');

        return true;
    }).catch((err) => {
        console.log(err);
        return false;
    });
}