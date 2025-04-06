import os
import time
import subprocess
import logging

# Настройка логирования
logging.basicConfig(
    filename=r"C:\OSPanelV6\home\desktopshop.local\sync.log",  # Путь к файлу логов
    level=logging.DEBUG,  # Уровень логирования (DEBUG — самый подробный)
    format="%(asctime)s - %(levelname)s - %(message)s"  # Формат логов
)

# Путь к папке проекта
project_path = r"C:\OSPanelV6\home\desktopshop.local"

# Команды Git
def git_push():
    try:
        logging.info("Начинаем процесс синхронизации с GitHub...")
        
        # Добавляем все файлы
        subprocess.run(["git", "add", "."], cwd=project_path, check=True)
        logging.info("Файлы успешно добавлены в индекс Git.")
        
        # Делаем коммит
        commit_message = "Automatic synchronization"
        subprocess.run(["git", "commit", "-m", commit_message], cwd=project_path, check=True)
        logging.info(f"Коммит выполнен: {commit_message}")
        
        # Отправляем изменения на GitHub
        subprocess.run(["git", "push", "origin", "main"], cwd=project_path, check=True)
        logging.info("Изменения успешно отправлены на GitHub!")
    except subprocess.CalledProcessError as e:
        logging.error(f"Ошибка при выполнении команды Git: {e}")
    except Exception as e:
        logging.error(f"Неожиданная ошибка: {e}")

# Отслеживание изменений
last_modified = 0
logging.info("Скрипт запущен. Начинаем отслеживание изменений...")

while True:
    try:
        # Получаем время последнего изменения файлов в папке
        current_modified = max(
            os.path.getmtime(os.path.join(project_path, f))
            for f in os.listdir(project_path)
            if os.path.isfile(os.path.join(project_path, f))  # Учитываем только файлы
        )
    except ValueError:
        current_modified = 0  # Если папка пустая или нет файлов
        logging.warning("Папка проекта пуста или не содержит файлов.")

    logging.debug(f"Текущее время модификации: {current_modified}, Последнее время модификации: {last_modified}")

    # Если обнаружены изменения
    if current_modified > last_modified:
        logging.info("Обнаружены изменения. Запуск синхронизации...")
        git_push()
        last_modified = current_modified  # Обновляем время последнего изменения
    else:
        logging.debug("Изменений нет.")

    # Проверяем каждые 5 секунд
    time.sleep(5)