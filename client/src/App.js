import {BrowserRouter, Route, Routes} from "react-router-dom";
import {ChakraProvider} from '@chakra-ui/react';
import 'react-big-calendar/lib/css/react-big-calendar.css';
import Navbar from "./components/Navbar";
import Home from "./screens/Home/Home";
import Register from "./screens/Register/Register";
import ClientLogin from "./screens/Login/Client/ClientLogin";

function App() {
  return (
    <ChakraProvider>
        <BrowserRouter>
            <Navbar/>
            <Routes>
                <Route path="/" element={ <Home/> }/>
                <Route path="/register" element={ <Register/> }/>
                <Route path="/login" element={ <ClientLogin/> }/>
            </Routes>
        </BrowserRouter>
    </ChakraProvider>
  );
}

export default App;
