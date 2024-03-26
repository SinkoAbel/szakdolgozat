import { useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { clearAuth } from "../../state/reducers/authSlice";
import axios from "../../config/axios";

const Logout = async () => {
    const navigate = useNavigate();
    const {authenticated, token} = useSelector((state) => state.auth);
    
    if (!authenticated) {
        navigate('/');
        return;
    }

    await axios.post('/api/logout', {}, {
        headers: {
            Authorization: token
        }
    }).then(() => {
        clearAuth();
        navigate('/');
    }).catch((err) => {
        console.log(err);
    });
}

export default Logout;
