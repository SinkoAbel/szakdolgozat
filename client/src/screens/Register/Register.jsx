'use client'
import React from 'react';
import { useState } from 'react';
import { Link } from 'react-router-dom';
import { Flex, Box, FormControl, FormLabel, Input, InputGroup, HStack, InputRightElement, Stack, Button, Heading, Text,
        useColorModeValue } from '@chakra-ui/react';
import { ViewIcon, ViewOffIcon } from '@chakra-ui/icons';

const Register = () => {

    const [showPassword, setShowPassword] = useState(false);
    const [showPasswordAgain, setShowPasswordAgain] = useState(false);

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
                                   <FormControl id="firstName" isRequired>
                                       <FormLabel>Vezetéknév</FormLabel>
                                       <Input type="text" />
                                   </FormControl>
                               </Box>
                               <Box>
                                   <FormControl id="lastName" isRequired>
                                       <FormLabel>Keresztnév</FormLabel>
                                       <Input type="text" />
                                   </FormControl>
                               </Box>
                           </HStack>
                           <FormControl id="email" isRequired>
                               <FormLabel>Email cím</FormLabel>
                               <Input type="email" />
                           </FormControl>
                           <FormControl id="tajNumber" isRequired>
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
                           <Stack spacing={10} pt={2}>
                               <Button
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
