import re

from typing import List, Optional


DEFAULT_KNOWN_SKILLS = [

    "Laravel",
    "PHP",
    "Vue.js",
    "React",
    "Angular",
    "Node.js",
    "Python",
    "Java",
    "C++",
    "C#",
    "SQL",
    "MySQL",
    "PostgreSQL",
    "Docker",
    "Git",
    "HTML",
    "CSS",
    "JavaScript",
    "TypeScript",
    "Tailwind",
    "Bootstrap",
    "Symfony",
    "Spring Boot",
    "Flutter",
    "Android",
    "Swift",
    "Figma",

]


def clean_text(
    text: str
) -> str:

    if not text:

        return ""

    text = text.lower()

    text = re.sub(
        r"[^a-zA-Z0-9\s#\+\.]",
        " ",
        text
    )

    return " ".join(
        text.split()
    )


def calculate_level_weight(
    niveau: Optional[str]
) -> float:

    if not niveau:

        return 1.0

    niveau_clean = niveau.lower()

    if (
        "avanc" in niveau_clean
        or "expert" in niveau_clean
    ):

        return 1.5

    if (
        "interm" in niveau_clean
        or "moyen" in niveau_clean
    ):

        return 1.2

    return 1.0


def extract_skills_from_text(
    text: str,
    custom_skills: Optional[List[str]] = None
) -> List[str]:

    if not text:

        return []

    skills_to_check = list(
        set(
            DEFAULT_KNOWN_SKILLS
            + (custom_skills or [])
        )
    )

    found_skills = []

    text_lower = text.lower()

    for skill in skills_to_check:

        safe_skill = re.escape(
            skill.lower()
        )

        pattern = (
            r"(?<!\w)"
            + safe_skill
            + r"(?!\w)"
        )

        if re.search(
            pattern,
            text_lower
        ):

            found_skills.append(
                skill
            )

    return sorted(
        list(
            set(found_skills)
        )
    )