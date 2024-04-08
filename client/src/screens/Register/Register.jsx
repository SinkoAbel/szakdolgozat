'use client'
import React from 'react';
import { useState } from 'react';
import {Link, useNavigate} from 'react-router-dom';
import { Flex, Box, FormControl, FormLabel, Input, InputGroup, HStack, InputRightElement, Stack, Button, Heading, Text,
        useColorModeValue, 
} from '@chakra-ui/react';
import { ViewIcon, ViewOffIcon } from '@chakra-ui/icons';
import {useDispatch, useSelector} from "react-redux";
import {resetState, setBirthday, setBirthplace, setCity, setEmail, setFirstName, setHouseNumber, setInsuranceNumber, setLastName, setPassword, setPhone, setStreet, setZip} from "../../state/reducers/registerPatientSlice";
import { registerPatientEndpoint } from '../../config/endpoints';
import { ROLE_PATIENT } from '../../config/constants';
import reactAxios from '../../config/axios';

const Register = () => {
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

    const [showPassword, setShowPassword] = useState(false);
    const [showPasswordAgain, setShowPasswordAgain] = useState(false);
    
    const [confirmPassword, setConfirmPassword] = useState("");
    const isPasswordsMatching = confirmPassword === password;

    const [globalError, setGlobalError] = useState(false);
    const [successfulRegistration, setSuccessfulRegistration] = useState(false);

    const [firstNameError, setFirstNameError] = useState(false);
    const [lastNameError, setLastNameError] = useState(false);
    const [emailError, setEmailError] = useState(false);
    const [passwordError, setPasswordError] = useState(false);
    const [birthdayError, setBirthdayError] = useState(false);
    const [birthplaceError, setBirthplaceError] = useState(false);
    const [cityError, setCityError] = useState(false);
    const [zipError, setZipError] = useState(false);
    const [streetError, setStreetError] = useState(false);
    const [houseNumberError, setHouseNumberError] = useState(false);
    const [insuranceNumberError, setInsuranceNumberError] = useState(false);
    const [phoneError, setPhoneError] = useState(false);

    const navigate = useNavigate();
    const dispatch = useDispatch();

    const handlePatientRegistration = async (event) => {
        event.preventDefault();

        if (!isPasswordsMatching) {
            setGlobalError(true);
            return;
        }

        if (!first_name) {
            setFirstNameError(true);
            setGlobalError(true);
        }

        if (!last_name) {
            setLastNameError(true);
            setGlobalError(true);
        }

        if (!email) {
            setEmailError(true);
            setGlobalError(true);
        }

        if (!password) {
            setPasswordError(true);
            setGlobalError(true);
        }

        if (!birthday) {
            setBirthdayError(true);
            setGlobalError(true);
        }

        if (!birthplace) {
            setBirthplaceError(true);
            setGlobalError(true);
        }

        if (!city) {
            setCityError(true);
            setGlobalError(true);
        }

        if (!zip) {
            setZipError(true);
            setGlobalError(true);
        }

        if (!street) {
            setStreetError(true);
            setGlobalError(true);
        }

        if (!house_number) {
            setHouseNumberError(true);
            setGlobalError(true);
        }

        if (!insurance_number) {
            setInsuranceNumberError(true);
            setGlobalError(true);
        }

        if (!phone) {
            setPhoneError(true);
            setGlobalError(true);
        }

        if (globalError) {
            return;
        }

        await reactAxios.post(registerPatientEndpoint, {
            first_name: first_name,
            last_name: last_name,
            email: email,
            birthday: birthday,
            birthplace: birthplace,
            city: city,
            zip: zip,
            street: street,
            house_number: house_number,
            insurance_number: insurance_number,
            phone: phone,
            password: password,
            role: ROLE_PATIENT
        }).then(res => {
            setSuccessfulRegistration(true);
            
            setTimeout(() => {
                dispatch(resetState());
                navigate('/');
            }, 2000);
        }).catch(err => {
            console.log(err);
        });
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
                                        <Input type="text" onChange={(e) => {
                                                setLastNameError(false);
                                                setGlobalError(false);
                                                dispatch(setLastName(e.target.value))}
                                            } 
                                            value={last_name}/>
                                        { lastNameError &&
                                            <p className='text-red-500'>Adja meg a vezetéknevét!</p>}
                                    </FormControl>
                                 </Box>
                                 <Box>
                                    <FormControl id="first_name" isRequired>
                                        <FormLabel>Keresztnév</FormLabel>
                                        <Input type="text" onChange={(e) => {
                                                    setLastNameError(false);
                                                    setGlobalError(false);
                                                    dispatch(setFirstName(e.target.value))}
                                                } value={first_name}/>
                                        {firstNameError && 
                                            <p className='text-red-500'>Adja meg a keresztnevét!</p>}
                                    </FormControl>
                                </Box>
                            </HStack>
                            <FormControl id="email" isRequired>
                                <FormLabel>Email cím</FormLabel>
                                <Input type="email" onChange={(e) => {
                                        setEmailError(false);
                                        setGlobalError(false);
                                        dispatch(setEmail(e.target.value))}
                                    } value={email}/>
                                { emailError &&
                                    <p className='text-red-500'>Adja meg az email címét!</p>}
                            </FormControl>
                            <FormControl id="insurance_number" isRequired>
                                <FormLabel>Taj szám</FormLabel>
                                <Input type="text" onChange={(e) => {
                                        setInsuranceNumberError(false);
                                        setGlobalError(false);
                                        dispatch(setInsuranceNumber(e.target.value))}
                                    } value={insurance_number}/>
                                { insuranceNumberError &&
                                    <p className='text-red-500'>Adja meg a TAJ számát!</p>}
                            </FormControl>
                            <FormControl id="password" isRequired>
                                <FormLabel>Jelszó</FormLabel>
                                <InputGroup>
                                    <Input type={showPassword ? 'text' : 'password'} onChange={(e) => {
                                            setPasswordError(false);
                                            setGlobalError(false);
                                            dispatch(setPassword(e.target.value))}
                                        } value={password}/>
                                    <InputRightElement h={'full'}>
                                        <Button
                                            variant={'ghost'}
                                            onClick={() => setShowPassword((showPassword) => !showPassword)}>
                                            {showPassword ? <ViewIcon /> : <ViewOffIcon />}
                                        </Button>
                                    </InputRightElement>
                                </InputGroup>
                                { passwordError &&
                                    <p className='text-red-500'>Adja meg a jelszavát!</p>}
                            </FormControl>
                            <FormControl id="password_again" isRequired>
                                <FormLabel>Jelszó megint</FormLabel>
                                <InputGroup>
                                    <Input type={showPasswordAgain ? 'text' : 'password'} onChange={(e) => setConfirmPassword(e.target.value)} value={confirmPassword}/>
                                    <InputRightElement h={'full'}>
                                        <Button
                                           variant={'ghost'}
                                           onClick={() => setShowPasswordAgain((showPasswordAgain) => !showPasswordAgain)}>
                                           {showPasswordAgain ? <ViewIcon /> : <ViewOffIcon />}
                                        </Button>
                                    </InputRightElement>
                                </InputGroup>
                                { !isPasswordsMatching &&
                                    <p className='text-red-500'>A jelszavak nem egyeznek!</p>}
                            </FormControl>
                            <FormControl id="birhday" isRequired>
                                <FormLabel>Születési dátum</FormLabel>
                                <Input type="date" onChange={(e) => {
                                        setBirthdayError(false);
                                        setGlobalError(false);
                                        dispatch(setBirthday(e.target.value))}
                                    } value={birthday}/>
                                { birthdayError &&
                                    <p className='text-red-500'>Adja meg a születési dátumát!</p>}
                            </FormControl>
                            <FormControl id="birthplace" isRequired>
                                <FormLabel>Születési hely</FormLabel>
                                <Input type="text" onChange={(e) => {
                                        setBirthplaceError(false);
                                        setGlobalError(false);
                                        dispatch(setBirthplace(e.target.value))}
                                    } value={birthplace}/>
                                { birthplaceError &&
                                    <p className='text-red-500'>Adja meg a születési helyét!</p>}
                            </FormControl>
                            <FormControl id="zip" isRequired>
                                <FormLabel>Irányítószám</FormLabel>
                                <Input type="number" mask="****" onChange={(e) => {
                                        setZipError(false);
                                        setGlobalError(false);
                                        dispatch(setZip(e.target.value))}
                                    } value={zip}/>
                                { zipError &&
                                    <p className='text-red-500'>Adja meg az irányítószámát!</p>}
                            </FormControl>
                            <FormControl id="city" isRequired>
                                <FormLabel>Lakhely</FormLabel>
                                <Input type="text" onChange={(e) => {
                                        setCityError(false);
                                        setGlobalError(false);
                                        dispatch(setCity(e.target.value))}
                                    } value={city}/>
                                { cityError &&
                                    <p className='text-red-500'>Adja meg lakhelyét!</p>}
                            </FormControl>
                            <FormControl id="street" isRequired>
                                <FormLabel>Utca név</FormLabel>
                                <Input type="text" onChange={(e) => {
                                        setStreetError(false);
                                        setGlobalError(false);
                                        dispatch(setStreet(e.target.value))}
                                    } value={street}/>
                                { streetError &&
                                    <p className='text-red-500'>Adja meg az utca nevét!</p>}
                            </FormControl>
                            <FormControl id="house_number" isRequired>
                                <FormLabel>Házszám</FormLabel>
                                <Input type="number" onChange={(e) => {
                                        setHouseNumberError(false);
                                        setGlobalError(false);
                                        dispatch(setHouseNumber(e.target.value))}
                                    } value={house_number}/>
                                { houseNumberError &&
                                    <p className='text-red-500'>Adja meg a házszámát!</p>}
                            </FormControl>
                            <FormControl id="phone" isRequired>
                                 <FormLabel>Telefonszám</FormLabel>
                                 <Input type="tel" onChange={(e) => {
                                        setPhoneError(false);
                                        setGlobalError(false);
                                        dispatch(setPhone(e.target.value))}
                                    } value={phone}/>
                                 { phoneError &&
                                    <p className='text-red-500'>Adja meg a telefonszámát!</p>}
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
                            {   successfulRegistration &&
                                    <div className='bg-green-200 rounded-lg'>
                                        <p className='text-center font-bold py-3'>Sikeres regisztráció!</p>
                                    <p className='text-center pb-3'>Vissza irányítjuk a főoldalra!</p>
                            </div>
                            }
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
