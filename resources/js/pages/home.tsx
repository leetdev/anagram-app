import { postApi } from '@/lib/utils'
import { find } from '@/routes/anagram'
import { WordBase } from '@/types'
import { Head } from '@inertiajs/react'
import { useState } from 'react'

interface Props {
    wordBases: WordBase[]
}

export default function Home({ wordBases }: Props) {
    const [wordBaseId, setWordBaseId] = useState<number>(wordBases[0].id ?? 0)
    const [anagrams, setAnagrams] = useState<string[]>([])

    const submit = e => {
        const word = e.target.value
        if (word != '') {
            postApi(find.url(), { wordBaseId, word })
                .then(result => {
                    setAnagrams(result.anagrams)
                })
        } else {
            setAnagrams([])
        }
    }

    return (
        <>
            <Head>
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div
                className="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
                <div
                    className="flex w-full items-center justify-center opacity-100 transition-opacity duration-750 lg:grow starting:opacity-0">
                    <main className="flex w-full max-w-[335px] flex-col-reverse lg:max-w-4xl lg:flex-row">
                        <div
                            className="flex-1 rounded-br-lg rounded-bl-lg bg-white p-6 pb-12 text-[13px] leading-[20px] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] lg:rounded-tl-lg lg:rounded-br-none lg:p-20 dark:bg-[#161615] dark:text-[#EDEDEC] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
                            <h1 className="mb-1 font-medium">Anagram Finder</h1>
                            <div className="space-y-4">
                                <div>
                                    <label className="block font-bold">Word list</label>
                                    <select onChange={e => setWordBaseId(parseInt(e.target.value))}>
                                        {wordBases.map(base => <option
                                            value={base.id}>{base.name} ({base.url})</option>)}
                                    </select>
                                    <a className="ml-2 inline-flex items-center space-x-1 font-medium text-[#f53003] underline underline-offset-4 dark:text-[#FF4433]"
                                       href="/import">
                                        Import
                                    </a>
                                </div>
                                <div>
                                    <label className="block font-bold">Search</label>
                                    <input
                                        type="text"
                                        className="border p-2 w-full"
                                        onChange={submit}
                                    />
                                </div>
                                {anagrams.length > 0 ? <div>
                                    <label className="block font-bold">Anagrams</label>
                                    <ul className="uppercase">
                                        {anagrams.map(anagram => <li>{anagram}</li>)}
                                    </ul>
                                </div> : ''}
                            </div>

                        </div>
                    </main>
                </div>
            </div>
        </>
    )
}
