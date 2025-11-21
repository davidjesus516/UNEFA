import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

// El componente recibe 'cursos' como una prop del Laravel CursoController
export default function CursosIndex({ auth, cursos }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-2xl text-gray-800 leading-tight">Gestión de Cursos</h2>}
        >
            <Head title="Cursos" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                        <div className="p-6">
                            <h3 className="text-xl font-medium text-gray-900 mb-6">Listado de Cursos Disponibles ({cursos.length})</h3>
                            
                            {/* Estructura de la Tabla */}
                            <div className="overflow-x-auto">
                                <table className="min-w-full divide-y divide-gray-200">
                                    <thead className="bg-gray-50">
                                        <tr>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre del Curso</th>
                                            <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        </tr>
                                    </thead>
                                    <tbody className="bg-white divide-y divide-gray-200">
                                        {cursos.map((curso) => (
                                            <tr key={curso.id} className="hover:bg-indigo-50">
                                                <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-indigo-600">{curso.codigo}</td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{curso.nombre}</td>
                                                <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{curso.id}</td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            </div>
                            
                            {/* Botón para crear un nuevo curso (futura funcionalidad) */}
                            <button className="mt-6 bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-150">
                                + Nuevo Curso
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}