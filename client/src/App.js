import {BrowserRouter, Route, Routes} from "react-router-dom";
import {ChakraProvider} from '@chakra-ui/react';
import Navbar from "./components/Navbar";
import Home from "./screens/Home/Home";
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
import { ROLE_ADMIN, ROLE_DOCTOR, ROLE_PATIENT } from "./config/constants";
import PatientNavbar from "./components/Navbar/Patient/PatientNavbar";
import DoctorNavbar from "./components/Navbar/Doctor/DoctorNavbar";
import AdminNavbar from "./components/Navbar/Admin/AdminNavbar";

function App() {
  const role = window.sessionStorage.getItem('role');

  let navbar;

  switch (role) {
    case ROLE_PATIENT:
      navbar = <PatientNavbar/>;
      break;
    case ROLE_DOCTOR:
      navbar = <DoctorNavbar/>;
      break;
    case ROLE_ADMIN:
      navbar = <AdminNavbar/>;
      break;
    default:
      navbar = <Navbar/>;
  }

  return (
    <ChakraProvider>
        <BrowserRouter>
            {navbar}
            <Routes>
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
            </Routes>
        </BrowserRouter>
    </ChakraProvider>
  );
}

export default App;
