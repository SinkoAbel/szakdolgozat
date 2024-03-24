'use client'
import React from 'react';
import { useState } from 'react';
import {Link, useNavigate} from 'react-router-dom';
import { Flex, Box, FormControl, FormLabel, Input, InputGroup, HStack, InputRightElement, Stack, Button, Heading, Text,
        useColorModeValue } from '@chakra-ui/react';
import { ViewIcon, ViewOffIcon } from '@chakra-ui/icons';
import {useDispatch, useSelector} from "react-redux";
import {setFirstName, setLastName} from "../../state/reducers/registerPatientSlice";

const Register = () => {

    const [showPassword, setShowPassword] = useState(false);
    const [showPasswordAgain, setShowPasswordAgain] = useState(false);

    const navigate = useNavigate();
    const dispatch = useDispatch();

    const {
        first_name,
        last_name,
        email,
        password,
        birthday,
        birthplace,
        city,
        zip,
        street,
        house_number,
        insurance_number,
        phone
    } = useSelector((state) => state.registerPatient);

    const handlePatientRegistration = () => {
        console.log('register triggered');
    }

    const handleLastNameChange = (event) => {
        dispatch(setLastName(event.target.value));
    }

    const handleFirstNameChange = (event) => {
        dispatch(setFirstName(event.target.value));
    }


    return (
        <>
           <Flex
               minH={'100vh'}
               align={'center'}
               justify={'center'}
               bg={useColorModeValue('gray.50', 'gray.800')}>
               <Stack spacing={8} mx={'auto'} maxW={'lg'} py={12} px={6}>
                   <Stack align={'center'}>
                       <Heading fontSize={'4xl'} textAlign={'center'}>
                            Regisztráció
                       </Heading>
                   </Stack>
                   <Box
                       rounded={'lg'}
                       bg={useColorModeValue('white', 'gray.700')}
                       boxShadow={'lg'}
                       p={8}>
                       <Stack spacing={4}>
                           <HStack>
                               <Box>
                                   <FormControl id="last_name" isRequired>
                                       <FormLabel>Vezetéknév</FormLabel>
                                       <Input type="text" onChange={handleLastNameChange}/>
                                   </FormControl>
                               </Box>
                               <Box>
                                   <FormControl id="first_name" isRequired>
                                       <FormLabel>Keresztnév</FormLabel>
                                       <Input type="text" onChange={handleFirstNameChange}/>
                                   </FormControl>
                               </Box>
                           </HStack>
                           <FormControl id="email" isRequired>
                               <FormLabel>Email cím</FormLabel>
                               <Input type="email" />
                           </FormControl>
                           <FormControl id="insurance_number" isRequired>
                               <FormLabel>Taj szám</FormLabel>
                               <Input type="number" mask="***-***-***"/>
                           </FormControl>
                           <FormControl id="password" isRequired>
                              <FormLabel>Jelszó</FormLabel>
                               <InputGroup>
                                   <Input type={showPassword ? 'text' : 'password'} />
                                   <InputRightElement h={'full'}>
                                       <Button
                                           variant={'ghost'}
                                           onClick={() => setShowPassword((showPassword) => !showPassword)}>
                                           {showPassword ? <ViewIcon /> : <ViewOffIcon />}
                                       </Button>
                                   </InputRightElement>
                               </InputGroup>
                           </FormControl>
                           <FormControl id="password_again" isRequired>
                               <FormLabel>Jelszó megint</FormLabel>
                               <InputGroup>
                                   <Input type={showPasswordAgain ? 'text' : 'password'} />
                                   <InputRightElement h={'full'}>
                                       <Button
                                           variant={'ghost'}
                                           onClick={() => setShowPasswordAgain((showPasswordAgain) => !showPasswordAgain)}>
                                           {showPasswordAgain ? <ViewIcon /> : <ViewOffIcon />}
                                       </Button>
                                   </InputRightElement>
                               </InputGroup>
                           </FormControl>
                           <FormControl id="birhday" isRequired>
                               <FormLabel>Születési dátum</FormLabel>
                               <Input type="number" mask="***-***-***"/>
                           </FormControl>
                           <FormControl id="birthplace" isRequired>
                               <FormLabel>Születési hely</FormLabel>
                               <Input type="number" mask="***-***-***"/>
                           </FormControl>
                           <FormControl id="zip" isRequired>
                               <FormLabel>Irányítószám</FormLabel>
                               <Input type="number" mask="***-***-***"/>
                           </FormControl>
                           <FormControl id="city" isRequired>
                               <FormLabel>Lakhely</FormLabel>
                               <Input type="number" mask="***-***-***"/>
                           </FormControl>
                           <FormControl id="street" isRequired>
                               <FormLabel>Utca név</FormLabel>
                               <Input type="number" mask="***-***-***"/>
                           </FormControl>
                           <FormControl id="house_number" isRequired>
                               <FormLabel>Házszám</FormLabel>
                               <Input type="number" mask="***-***-***"/>
                           </FormControl>
                           <FormControl id="phone" isRequired>
                               <FormLabel>Telefonszám</FormLabel>
                               <Input type="number" mask="***-***-***"/>
                           </FormControl>
                           <Stack spacing={10} pt={2}>
                               <Button
                                   onClick={handlePatientRegistration}
                                   loadingText="Submitting"
                                   size="lg"
                                   bg={'blue.400'}
                                   color={'white'}
                                   _hover={{
                                       bg: 'blue.500',
                                   }}>
                                   Regisztrálok
                               </Button>
                           </Stack>
                           <Stack pt={6}>
                               <Text align={'center'}>
                                   Már regisztrált ügyfelünk?
                               </Text>
                               <Link to="/login" className="underline text-green-600 text-center">
                                   Jelentkezzen be!
                               </Link>
                           </Stack>
                       </Stack>
                   </Box>
               </Stack>
           </Flex>
        </>
    );
};

export default Register;
