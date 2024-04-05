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

            // TODO: should replace session with state?
            window.sessionStorage.setItem('token', 'Bearer ' +  response.data.token);
            window.sessionStorage.setItem('user_id', response.data.id);
            window.sessionStorage.setItem('authenticated', true);
            window.sessionStorage.setItem('role', role);

            return true;
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


export const logout = async () => {
    const token = window.sessionStorage.getItem('token');

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