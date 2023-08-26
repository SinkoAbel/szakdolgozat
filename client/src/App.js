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

function App() {
  return (
    <ChakraProvider>
        <BrowserRouter>
            <Navbar/>
            <Routes>
                <Route path="/" element={ <Home/> }/>
                <Route path="/register" element={ <Register/> }/>
                <Route path="/login" element={ <ClientLogin/> }/>
                <Route path="/admin" element={ <AdminLogin/> }/>
                <Route path="/about" element={ <About/> }/>
                <Route path="/service-locations" element={ <Locations/> }/>
            </Routes>
        </BrowserRouter>
    </ChakraProvider>
  );
}

export default App;
