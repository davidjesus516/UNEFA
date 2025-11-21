// resources/js/Pages/HomePage.jsx

import React from 'react';
import { Head } from '@inertiajs/react';
// Importamos el layout de autenticación de Breeze, aunque no lo usaremos aquí, 
// es útil si quieres la barra superior de login/registro.
import GuestLayout from '@/Layouts/GuestLayout'; 

export default function HomePage() {
    return (
        <GuestLayout>
            <Head title="Inicio" /> 

            <div className="relative flex items-top justify-center min-h-screen bg-gray-100 sm:items-center py-4 sm:pt-0">
                <div className="max-w-6xl mx-auto sm:px-6 lg:px-8 text-center">
                    
                    {/* Sección Principal de Bienvenida */}
                    <div className="bg-white overflow-hidden shadow sm:rounded-lg p-6 lg:p-10">
                        <h1 className="text-5xl font-extrabold text-indigo-700 mb-4">
                            Bienvenidos a la UNEFA
                        </h1>
                        <p className="text-xl text-gray-600 mb-8">
                            Tu portal central para la gestión académica.
                        </p>

                        {/* Botones de Navegación */}
                        <div className="space-x-4 flex justify-center">
                            <a 
                                href={route('login')} 
                                className="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 shadow-md"
                            >
                                Iniciar Sesión
                            </a>
                            
                            <a 
                                href={route('register')} 
                                className="inline-block bg-white border border-indigo-600 text-indigo-600 hover:bg-indigo-50 font-bold py-3 px-6 rounded-lg transition duration-300"
                            >
                                Registrarse
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
        </GuestLayout>
    );
}