'use client'

import {
    Box,
    Flex,
    HStack,
    IconButton,
    useDisclosure,
    useColorModeValue,
    Stack,
  } from '@chakra-ui/react';
import { HamburgerIcon, CloseIcon } from '@chakra-ui/icons';
import {logout} from '../../../config/auth';
import {useNavigate} from "react-router-dom";
import {useDispatch} from "react-redux";
import {setGuestRole, setLoggedInFalse} from "../../../state/reducers/authenticationSlice";


const DoctorNavbar = () => {
    const navigate = useNavigate();
    const dispatch = useDispatch();
    const { isOpen, onOpen, onClose } = useDisclosure();

    return (
        <>
            <Box bg={useColorModeValue('gray.100', 'gray.900')} px={4}>
                <Flex h={16} alignItems={'center'} justifyContent={'space-between'}>
                    <IconButton
                        size={'md'}
                        icon={isOpen ? <CloseIcon /> : <HamburgerIcon />}
                        aria-label={'Open Menu'}
                        display={{ md: 'none' }}
                        onClick={isOpen ? onClose : onOpen}
                    />
                    <HStack spacing={8} alignItems={'center'}>
                        <HStack as={'nav'} spacing={4} display={{ base: 'none', md: 'flex' }}>
                            <Box
                                as="a"
                                px={2}
                                py={1}
                                rounded={'md'}
                                _hover={{
                                    textDecoration: 'none',
                                    bg: useColorModeValue('gray.200', 'gray.700'),
                                }}
                                href={'/doctor/dashboard'}
                                >
                                    Kezelőfelület
                            </Box>
                            <Box
                                as="a"
                                px={2}
                                py={1}
                                rounded={'md'}
                                _hover={{
                                    textDecoration: 'none',
                                    bg: useColorModeValue('gray.200', 'gray.700'),
                                }}
                                href={'/doctor/calendar'}
                                >
                                    Naptár
                            </Box>
                            <Box
                                as="a"
                                px={2}
                                py={1}
                                rounded={'md'}
                                _hover={{
                                    textDecoration: 'none',
                                    bg: useColorModeValue('gray.200', 'gray.700'),
                                }}
                                href={'/doctor/appointment/creator'}
                                >
                                    Időpont létrehozása
                            </Box>
                            <Box
                                as="a"
                                px={2}
                                py={1}
                                rounded={'md'}
                                _hover={{
                                    textDecoration: 'none',
                                    bg: useColorModeValue('gray.200', 'gray.700'),
                                }}
                                onClick={() => {
                                    logout();
                                    dispatch(setLoggedInFalse());
                                    dispatch(setGuestRole());
                                    navigate('/');
                                }}
                                >
                                    Kifejelentkezés
                            </Box>
                        </HStack>
                    </HStack>
                </Flex>

                {isOpen ? (
                <Box pb={4} display={{ md: 'none' }}>
                    <Stack as={'nav'} spacing={4}>
                    <Box
                        as="a"
                        px={2}
                        py={1}
                        rounded={'md'}
                        _hover={{
                            textDecoration: 'none',
                        }}
                        href={'/doctor/dashboard'}
                        >
                            Kezelőfelület
                    </Box>
                        <Box
                            as="a"
                            px={2}
                            py={1}
                            rounded={'md'}
                            _hover={{
                                textDecoration: 'none',
                            }}
                            href={'/doctor/calendar'}
                            >
                                Naptár
                        </Box>
                        <Box
                            as="a"
                            px={2}
                            py={1}
                            rounded={'md'}
                            _hover={{
                                textDecoration: 'none',
                            }}
                            href={'/doctor/appointment/creator'}
                            >
                                Időpont létrehozása
                        </Box>
                        <Box
                            as="a"
                            px={2}
                            py={1}
                            rounded={'md'}
                            _hover={{
                                textDecoration: 'none',
                            }}
                            onClick={() => {
                                logout();
                                dispatch(setGuestRole());
                                dispatch(setLoggedInFalse());
                                navigate('/');
                            }}
                            style={{cursor: 'pointer'}}
                            >
                                Kifejelentkezés
                        </Box>
                    </Stack>
                </Box>
                ) : null}
            </Box>
        </>
    );
}

export default DoctorNavbar;
