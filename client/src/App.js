import {BrowserRouter, Route, Routes} from "react-router-dom";
import {ChakraProvider} from '@chakra-ui/react';
import 'react-big-calendar/lib/css/react-big-calendar.css';
import Navbar from "./components/Navbar";
import Home from "./screens/Home/Home";

function App() {
  return (
    <ChakraProvider>
        <BrowserRouter>
            <Navbar/>
            <Routes>
                <Route path="/" element={<Home/>}/>
            </Routes>
        </BrowserRouter>
    </ChakraProvider>
  );
}

export default App;
