import {BrowserRouter, Route, Routes} from "react-router-dom";
import {ChakraProvider} from '@chakra-ui/react';
import Home from "./screens/Home/Home";
import Navbar from "./components/Navbar/Navbar";
import Register from "./screens/Register/Register";
import ClientLogin from "./screens/Login/Client/ClientLogin";
import About from "./screens/About/About";
import Locations from "./screens/Locations/Locations";
import AdminLogin from "./screens/Login/Admin/AdminLogin";
import PriceList from "./screens/PriceList/PriceList";
import PatientDashboard from "./screens/Dashboards/Patient/PatientDashboard";
import DoctorLogin from "./screens/Login/Doctor/DoctorLogin";
import DoctorDashboard from "./screens/Dashboards/Doctor/DoctorDashboard";
import DoctorAppointmentCreator from "./screens/Appointments/Doctor/DoctorAppointmentCreator";
import DoctorCalendar from "./screens/Appointments/Doctor/DoctorCalendar";
import NotFound from "./screens/404/NotFound";
import {ROLE_ADMIN, ROLE_DOCTOR, ROLE_PATIENT} from "./config/constants";
import DoctorNavbar from "./components/Navbar/Doctor/DoctorNavbar";
import PatientNavbar from "./components/Navbar/Patient/PatientNavbar";
import AdminNavbar from "./components/Navbar/Admin/AdminNavbar";
import Appointment from "./screens/Appointment/Appointment";
import AppointmentDetail from "./screens/Appointments/Doctor/AppointmentDetail";
import PatientBooker from "./screens/Appointments/Patient/PatientBooker";
import PatientProfile from "./screens/Profiles/Patient/PatientProfile";

function App() {

    // TODO: doesn't change automatically!
    const role = window.sessionStorage.getItem('role');

  return (
    <ChakraProvider>
        <BrowserRouter>
            { role && role === ROLE_PATIENT &&
                <PatientNavbar/>
            }
            { role && role === ROLE_DOCTOR &&
                <DoctorNavbar/>
            }
            { role && role === ROLE_ADMIN &&
                <AdminNavbar/>
            }
            {
                !role &&
                    <Navbar/>
            }
            <Routes>
                <Route path="*" element={ <NotFound/> }/>
                <Route path="/" element={ <Home/> }/>
                <Route path="/register" element={ <Register/> }/>
                <Route path="/login" element={ <ClientLogin/> }/>
                <Route path="/doctor/login" element={ <DoctorLogin/> }/>
                <Route path="/admin/login" element={ <AdminLogin/> }/>
                <Route path="/about" element={ <About/> }/>
                <Route path="/prices" element={ <PriceList/> }/>
                <Route path="/service-locations" element={ <Locations/> }/>
                <Route path="/patient/dashboard" element={ <PatientDashboard/> }/>
                <Route path="/doctor/dashboard" element={ <DoctorDashboard/> }/>
                <Route path="/doctor/appointment/creator" element={ <DoctorAppointmentCreator/> }/>
                <Route path="/doctor/calendar" element={ <DoctorCalendar/> }/>
                <Route path="/appointment/:appointmentId" element={ <Appointment/> }/>
                <Route path="/appointment/detail/:appointmentId" element={ <AppointmentDetail/> }/>
                <Route path="/patient/booking" element={ <PatientBooker/> }/>
                <Route path="/patient/profile" element={ <PatientProfile/> }/>
            </Routes>
        </BrowserRouter>
    </ChakraProvider>
  );
}

export default App;
