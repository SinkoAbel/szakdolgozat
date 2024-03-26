import { useNavigate } from "react-router-dom";

const DoctorLogout = () => {
    const navigate = useNavigate();

    // TODO: implement patient logout
    /*const {patientAuthenticated} = useSelector((state) => state.authPatient);
    
    if (patientAuthenticated) {
        navigate('/');
    }

    clearPatientAuth();*/
    navigate('/');
}

export default DoctorLogout;
