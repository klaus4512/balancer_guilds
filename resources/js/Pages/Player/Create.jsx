import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm, Link } from '@inertiajs/react';
import TextInput from '@/Components/TextInput';
import ButtonLink from "@/Components/ButtonLink.jsx";
import PrimaryButton from "@/Components/PrimaryButton.jsx";
export default function CreatePlayer({ characterClasses = [] }) {
    const { data, setData, post, processing, errors } = useForm({
        name: '',
        characterClass: '',
        level: '',
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('player.store'));
    };

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Criar jogador
                </h2>
            }
        >
            <Head title="Criar Player" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <form onSubmit={submit}>
                                <div>
                                    <label htmlFor="name">Nome</label>
                                    <TextInput
                                        id="name"
                                        type="text"
                                        value={data.name}
                                        onChange={(e) => setData('name', e.target.value)}
                                        className="mt-1 block w-full"
                                    />
                                    {errors.name && <div className="text-red-600">{errors.name}</div>}
                                </div>

                                <div className="mt-4">
                                    <label htmlFor="characterClass">Classe</label>
                                    <select
                                        id="characterClass"
                                        value={data.characterClass}
                                        onChange={(e) => setData('characterClass', e.target.value)}
                                        className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    >
                                        <option value="">Selecione uma classe</option>
                                        {characterClasses.map((classOption) => (
                                            <option key={classOption.value} value={classOption.value}>
                                                {classOption.description}
                                            </option>
                                        ))}
                                    </select>
                                    {errors.characterClass &&
                                        <div className="text-red-600">{errors.characterClass}</div>}
                                </div>

                                <div className="mt-4">
                                    <label htmlFor="level">Nível</label>
                                    <TextInput
                                        id="level"
                                        type="number"
                                        value={data.level}
                                        onChange={(e) => setData('level', e.target.value)}
                                        className="mt-1 block w-full"
                                    />
                                    {errors.level && <div className="text-red-600">{errors.level}</div>}
                                </div>

                                <div className="mt-4">
                                    <PrimaryButton type="submit" className="mr-4" disabled={processing}>
                                        Criar
                                    </PrimaryButton>
                                    <ButtonLink href={route('player.index')}> Cancelar </ButtonLink>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
