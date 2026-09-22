// Used only when VITE_USE_MOCK=true

export const MOCK_RESPONSE = {

  skills: [
    'Vue.js',
    'JavaScript',
    'Tailwind CSS',
    'HTML',
    'CSS',
    'Git',
    'Docker',
    'PostgreSQL',
    'Node.js',
    'REST APIs'
  ],

  offers: [

    {
      id: 1,
      title: 'Frontend Developer',
      company: 'Northwind Labs',
      location: 'Remote',
      type: 'Full-time',
      score: 100,
      matched: [
        'Vue.js',
        'JavaScript',
        'Tailwind CSS',
        'HTML',
        'CSS',
        'Git'
      ],
      missing: [],
      reasoning:
        'Excellent match. Your frontend skills strongly correspond to this position.',
      url: '#'
    },

    {
      id: 2,
      title: 'Full-Stack Engineer',
      company: 'Brightpath',
      location: 'Casablanca',
      type: 'Full-time',
      score: 88,
      matched: [
        'Vue.js',
        'Node.js',
        'PostgreSQL',
        'Docker',
        'REST APIs',
        'Git'
      ],
      missing: [],
      reasoning:
        'Strong match across frontend, backend, database and DevOps skills.',
      url: '#'
    },

    {
      id: 3,
      title: 'Vue.js Engineer',
      company: 'Fjord Apps',
      location: 'Remote',
      type: 'Full-time',
      score: 72,
      matched: [
        'Vue.js',
        'Tailwind CSS',
        'Node.js'
      ],
      missing: [
        'TypeScript',
        'GraphQL',
        'CI/CD'
      ],
      reasoning:
        'Good Vue.js foundation, but several additional technologies are requested.',
      url: '#'
    },

    {
      id: 4,
      title: 'UI Engineer',
      company: 'Lumen Design Co.',
      location: 'Marrakesh',
      type: 'Contract',
      score: 67,
      matched: [
        'Vue.js',
        'Tailwind CSS',
        'CSS',
        'JavaScript'
      ],
      missing: [
        'Figma',
        'UI/UX Design'
      ],
      reasoning:
        'Your frontend skills match the technical side of the position.',
      url: '#'
    },

    {
      id: 5,
      title: 'Node.js Developer',
      company: 'Streamly',
      location: 'Remote',
      type: 'Full-time',
      score: 63,
      matched: [
        'Node.js',
        'JavaScript',
        'REST APIs',
        'Docker'
      ],
      missing: [
        'Express',
        'MongoDB'
      ],
      reasoning:
        'Good backend foundation with some missing Node.js ecosystem skills.',
      url: '#'
    },

    {
      id: 6,
      title: 'Junior Web Developer',
      company: 'Studio Atlas',
      location: 'Tangier',
      type: 'Internship',
      score: 60,
      matched: [
        'HTML',
        'CSS',
        'JavaScript'
      ],
      missing: [
        'PHP',
        'MySQL'
      ],
      reasoning:
        'Suitable frontend foundation with some backend skills still required.',
      url: '#'
    },

    {
      id: 7,
      title: 'React Developer',
      company: 'Pixelworks',
      location: 'Remote',
      type: 'Full-time',
      score: 52,
      matched: [
        'JavaScript',
        'CSS',
        'Git',
        'REST APIs'
      ],
      missing: [
        'React',
        'TypeScript'
      ],
      reasoning:
        'JavaScript experience is relevant, but React and TypeScript are missing.',
      url: '#'
    },

    {
      id: 8,
      title: 'DevOps Engineer',
      company: 'Cloudmesh',
      location: 'Remote',
      type: 'Full-time',
      score: 42,
      matched: [
        'Docker',
        'Git'
      ],
      missing: [
        'Kubernetes',
        'CI/CD',
        'AWS',
        'Linux'
      ],
      reasoning:
        'Some DevOps-related experience is present, but several core requirements are missing.',
      url: '#'
    },

    {
      id: 9,
      title: 'Backend Developer',
      company: 'Datacore',
      location: 'Rabat',
      type: 'Full-time',
      score: 50,
      matched: [
        'PostgreSQL',
        'Docker',
        'REST APIs'
      ],
      missing: [
        'Python',
        'Django',
        'Linux'
      ],
      reasoning:
        'Database and API experience is relevant, but backend framework requirements are missing.',
      url: '#'
    },

    {
      id: 10,
      title: 'Software Engineering Intern',
      company: 'Orbit Systems',
      location: 'Tangier',
      type: 'Internship',
      score: 40,
      matched: [
        'JavaScript',
        'Git'
      ],
      missing: [
        'SQL',
        'Agile',
        'Merise'
      ],
      reasoning:
        'Some general software development skills match this internship.',
      url: '#'
    }

  ]
}