import {BrowserRouter, Route, Routes} from "react-router-dom";
import {ChakraProvider} from '@chakra-ui/react';
import 'react-big-calendar/lib/css/react-big-calendar.css';
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

function App() {
  return (
    <ChakraProvider>
        <BrowserRouter>
            <Navbar/>
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
            </Routes>
        </BrowserRouter>
    </ChakraProvider>
  );
}

export default App;
