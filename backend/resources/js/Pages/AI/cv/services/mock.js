// Sample response used only when VITE_USE_MOCK=true
export const MOCK_RESPONSE = {
  skills: ['Vue.js', 'JavaScript', 'Tailwind CSS', 'HTML', 'CSS', 'Git', 'Docker', 'PostgreSQL', 'Node.js', 'REST APIs'],
  offers: [
    { id: 1, title: 'Frontend Developer', company: 'Northwind Labs', location: 'Remote', type: 'Full-time', score: 100, matched: ['Vue.js', 'JavaScript', 'Tailwind CSS', 'HTML', 'CSS', 'Git'], missing: [], url: '#' },
    { id: 2, title: 'Full-Stack Engineer', company: 'Brightpath', location: 'Casablanca', type: 'Full-time', score: 100, matched: ['Vue.js', 'Node.js', 'PostgreSQL', 'Docker', 'REST APIs', 'Git'], missing: [], url: '#' },
    { id: 3, title: 'Vue.js Engineer', company: 'Fjord Apps', location: 'Remote', type: 'Full-time', score: 50, matched: ['Vue.js', 'Tailwind CSS', 'Node.js'], missing: ['TypeScript', 'GraphQL', 'CI/CD'], url: '#' },
    { id: 4, title: 'UI Engineer', company: 'Lumen Design Co.', location: 'Marrakesh', type: 'Contract', score: 67, matched: ['Vue.js', 'Tailwind CSS', 'CSS', 'JavaScript'], missing: ['Figma', 'UI/UX Design'], url: '#' },
    { id: 5, title: 'Node.js Developer', company: 'Streamly', location: 'Remote', type: 'Full-time', score: 67, matched: ['Node.js', 'JavaScript', 'REST APIs', 'Docker'], missing: ['Express', 'MongoDB'], url: '#' },
    { id: 6, title: 'Junior Web Developer', company: 'Studio Atlas', location: 'Tangier', type: 'Internship', score: 60, matched: ['HTML', 'CSS', 'JavaScript'], missing: ['PHP', 'MySQL'], url: '#' },
    { id: 7, title: 'React Developer', company: 'Pixelworks', location: 'Remote', type: 'Full-time', score: 67, matched: ['JavaScript', 'CSS', 'Git', 'REST APIs'], missing: ['React', 'TypeScript'], url: '#' },
    { id: 8, title: 'DevOps Engineer', company: 'Cloudmesh', location: 'Remote', type: 'Full-time', score: 33, matched: ['Docker', 'Git'], missing: ['Kubernetes', 'CI/CD', 'AWS', 'Linux'], url: '#' },
    { id: 9, title: 'Backend Developer', company: 'Datacore', location: 'Rabat', type: 'Full-time', score: 50, matched: ['PostgreSQL', 'Docker', 'REST APIs'], missing: ['Python', 'Django', 'Linux'], url: '#' },
    { id: 10, title: 'Software Engineering Intern', company: 'Orbit Systems', location: 'Tangier', type: 'Internship', score: 40, matched: ['JavaScript', 'Git'], missing: ['SQL', 'Agile', 'Merise'], url: '#' }
  ]
}
