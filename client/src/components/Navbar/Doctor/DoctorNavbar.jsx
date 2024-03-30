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
import { useNavigate } from 'react-router-dom';
import { logout } from '../../../config/auth';

const MenuItems = [
    {
        name: 'Panel',
        link: '/doctor/dashboard',
        action: null,
    },
    {
        name: 'Naptár',
        link: '/doctor/calendar',
        action: null,
    },
    {
        name: 'Időpont létrehozása',
        link: '/doctor/appointment/creator',
        action: null,
    },
   {
        name: 'Kijelentkezés',
        link: '#',
    }
];

const NavLink = (props) => {
  const { children } = props

  return (
    <Box
      as="a"
      px={2}
      py={1}
      rounded={'md'}
      _hover={{
        textDecoration: 'none',
        bg: useColorModeValue('gray.200', 'gray.700'),
      }}
      href={children.link}
      onClick={children.action}
    >
      {children.name}
    </Box>
  )
}


const DoctorNavbar = () => {
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
                        {MenuItems.map((link) => (
                            <NavLink key={link.name}>{link}</NavLink>
                        ))}
                        </HStack>
                    </HStack>
                </Flex>

                {isOpen ? (
                <Box pb={4} display={{ md: 'none' }}>
                    <Stack as={'nav'} spacing={4}>
                        {MenuItems.map((link) => (
                            <NavLink key={link.name}>{link}</NavLink>
                        ))}
                    </Stack>
                </Box>
                ) : null}
            </Box>
        </>
    );
}

export default DoctorNavbar;
