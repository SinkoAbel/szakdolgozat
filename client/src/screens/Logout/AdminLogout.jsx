import { useNavigate } from "react-router-dom";


const AdminLogout = () => {
    const navigate = useNavigate();
    
    // TODO: implement admin logout
    /*const {patientAuthenticated} = useSelector((state) => state.authPatient);
    
    if (patientAuthenticated) {
        navigate('/');
    }

    clearPatientAuth();*/
    navigate('/');
}

export default AdminLogout;
