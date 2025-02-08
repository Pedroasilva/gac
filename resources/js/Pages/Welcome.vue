<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

</script>

<template>
    <Head title="Account" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div
            class="relative flex min-h-screen flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white"
        >
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header
                    class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3"
                >
                    <div class="flex lg:col-start-2 lg:justify-center">

                    </div>
                    <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Dashboard
                        </Link>

                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Log in
                            </Link>

                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Register
                            </Link>
                        </template>
                    </nav>
                </header>

                <main class="mt-6">
                    <div class="grid gap-6">
                        <div
                            href="https://laravel.com/docs"
                            id="docs-card"
                            class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]"
                        >

                            <div
                                class="relative flex items-center gap-6 lg:items-end"
                            >
                                <div
                                    id="docs-card-content"
                                    class="flex items-start gap-6 lg:flex-col"
                                >

                                    <div class="pt-3 sm:pt-5 lg:pt-0">
                                        <h2
                                            class="text-xl font-semibold text-black dark:text-white"
                                        >
                                        Desafio para full stack Grupo Adriano Cobuccio
                                        </h2>

                                        <p class="mt-4 text-sm/relaxed">
                                            <strong>Tecnologias desejadas:</strong>
                                            <ul class="list-disc list-inside">
                                                <li>PHP</li>
                                                <li>Laravel</li>
                                                <li>SQL</li>
                                            </ul>
                                        </p>
                                        <p class="mt-4 text-sm/relaxed">
                                            <strong>Para o dia da entrevista técnica:</strong>
                                            <ul class="list-disc list-inside">
                                                <li>Na data marcada pelo recrutador, tenha sua aplicação rodando para a execução de testes e para apresentação do desenvolvimento.</li>
                                                <li>Faremos um code review como se você já fosse do nosso time, você poderá explicar o que pensou.</li>
                                            </ul>
                                        </p>
                                        <p class="mt-4 text-sm/relaxed">
                                            <strong>Objetivo:</strong>
                                            <p>O objetivo consiste na criação de uma interface funcional equivalente a uma carteira financeira em que os usuários possam realizar transferência de saldo e depósito.</p>
                                        </p>
                                        <p class="mt-4 text-sm/relaxed">
                                            <strong>Requisitos:</strong>
                                            <ul class="list-disc list-inside">
                                                <li>Criar cadastro</li>
                                                <li>Criar autenticação</li>
                                                <li>Usuários podem enviar, receber e depositar dinheiro</li>
                                                <li>Validar se o usuário tem saldo antes da transferência e, caso o saldo da pessoa esteja negativo por algum motivo, no depósito deve acrescentar ao valor.</li>
                                                <li>A operação de transferência ou depósito deve ser passível de reversão em qualquer caso de inconsistência ou por solicitação do usuário.</li>
                                            </ul>
                                        </p>
                                        <p class="mt-4 text-sm/relaxed">
                                            <strong>Avaliação:</strong>
                                            <p>Apresente sua solução utilizando o framework que você desejar, justificando a escolha. Atente-se a cumprir a maioria dos requisitos, pois você pode cumpri-los parcialmente e durante a avaliação vamos bater um papo a respeito do que faltou.</p>
                                        </p>
                                        <p class="mt-4 text-sm/relaxed">
                                            <strong>O que será avaliado:</strong>
                                            <ul class="list-disc list-inside">
                                                <li>Segurança</li>
                                                <li>Uso de código limpo</li>
                                                <li>Domínio da arquitetura</li>
                                                <li>Tratamentos de erros</li>
                                                <li>Saber argumentar suas escolhas</li>
                                                <li>Conhecimento de padrões (design patterns, SOLID)</li>
                                                <li>Modelagem de dados</li>
                                            </ul>
                                        </p>
                                        <p class="mt-4 text-sm/relaxed">
                                            <strong>O que será um diferencial:</strong>
                                            <ul class="list-disc list-inside">
                                                <li>Uso de Docker</li>
                                                <li>Testes de integração</li>
                                                <li>Testes unitários</li>
                                                <li>Documentação</li>
                                                <li>Observabilidade</li>
                                            </ul>
                                        </p>
                                        <p class="mt-4 text-sm/relaxed">Boa sorte!</p>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </main>

                <footer
                    class="py-16 text-center text-sm text-black dark:text-white/70"
                >
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </footer>
            </div>
        </div>
    </div>
</template>
